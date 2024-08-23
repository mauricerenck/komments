<?php

namespace mauricerenck\Komments;

use Kirby\Filesystem\Dir;
use Kirby\Filesystem\F;
use Kirby\Toolkit\V;
use Kirby\Uuid\Uuid;
use Kirby\Content\Content;
use Kirby\Cms\Structure;

class Migrations
{
    public function __construct(
        private ?string $storageType = null,
        private ?string $sqlitePath = null,
        private ?bool $disableMigrations = null,
    ) {
        $this->storageType = $storageType ?? option('mauricerenck.komments.storage.type', 'markdown');
        $this->sqlitePath = $sqlitePath ?? option('mauricerenck.komments.storage.sqlitePath', '.sqlite/');
        $this->disableMigrations = $disableMigrations ?? option('mauricerenck.komments.disableMigrations', false);
    }

    public function migrate()
    {
        if ($this->storageType === 'sqlite' && !$this->disableMigrations) {
            $pluginPath = str_replace('lib', '', __DIR__);
            $migrationPath = $pluginPath . '/migrations/';

            if (!Dir::exists($migrationPath)) {
                return false;
            }

            if (!Dir::isReadable($migrationPath)) {
                return false;
            }

            $migrations = Dir::files($migrationPath, ['.', '..'], true);
            $database = new DatabaseAbstraction($this->sqlitePath, 'komments.sqlite');

            if ($database === null) {
                return false;
            }

            $versionResult = $database->select('migration', ['version'], 'ORDER BY version DESC LIMIT 1');

            foreach ($migrations as $migration) {
                $version = str_replace(['database_', '.sql'], ['', ''], F::filename($migration));
                $migrationStructures = explode(';', F::read($migration));
                $lastMigration = 0;

                if ($versionResult !== false) {
                    $lastMigration = (int) $versionResult->data[0]->version;
                }

                if ($lastMigration < $version) {
                    foreach ($migrationStructures as $query) {
                        if (!empty(trim($query))) {
                            $database->query(trim($query));
                        }
                    }
                }

                $database->insert('migrations', ['version'], [$version]);
            }
        }
    }

    public function convertCommentsFromMarkdownToSqlite(): void
    {

        switch ($this->storageType) {
            case 'sqlite':
                $storage = new StorageSqlite();
                break;
            case 'markdown':
                $storage = new StorageMarkdown();
                break;
            default:
                return;
        }

        $markdownConverter = new MarkdownConverter();

        // if there are already comments in the sqlite database, we don't need to convert them again
        $existingComments = $storage->getCommentsOfSite();
        if($existingComments->count() > 0) {
            return;
        }

        $pageList = site()->index();
        foreach ($pageList as $page) {
            $comments = $markdownConverter->getCommentsOfPage($page);
            $languageCodes = $markdownConverter->getAllLanguages();

            if (count($languageCodes) === 0) {
                $inbox = $markdownConverter->getInboxByLanguage($page);

                if (!is_null($inbox)) {
                    foreach ($inbox as $comment) {
                        $transformedComment = $this->convertCommentToNewFormat($comment, null, $page->uuid(), $storage);
                        $storage->saveComment($transformedComment);
                    }
                }

                continue;
            }

            $knownCommentIds = [];
            foreach ($languageCodes as $language) {
                $inbox = $markdownConverter->getInboxByLanguage($page, $language);

                if (!is_null($inbox)) {
                    foreach ($inbox->toStructure() as $comment) {
                        if(in_array($comment->id(),$knownCommentIds)) {
                            continue;
                        }
                        $knownCommentIds[] = $comment->id();
                        echo $comment->id().'<br>';
                        $transformedComment = $this->convertCommentToNewFormat($comment, $language, $page->uuid(), $storage);
                        $storage->saveComment($transformedComment);
                    }
                }
            }
        }
    }

    public function convertCommentToNewFormat($comment, ?string $language, string $pageUuid, $storage): Content {
        $id = $comment->id() ?? Uuid::generate();
        $parentId = V::url($comment->mentionof()) ? '' : $comment->mentionof();

        if($id == 0) {
            $id = Uuid::generate();
        }

        return $storage->createComment(
            id: $id,
            pageUuid: $pageUuid,
            parentId: $parentId,
            type: $this->transformTypes($comment->kommenttype()),
            content: $comment->komment(),
            authorName: $comment->author(),
            authorAvatar: $comment->avatar(),
            authorEmail: $comment->authoremail(),
            authorUrl: $comment->authorurl(),
            published: $comment->status() == 'true' ? true : false,
            verified: $comment->verified() == 'true' ? true : false,
            spamlevel: $comment->spamlevel()->value() ?? 0,
            language: $language,
            upvotes: 0,
            downvotes: 0,
            createdAt: $comment->published(),
            updatedAt: $comment->published(),
        );
    }

    public function removeMarkdownComments(): void {
        // TODO remove markdown comments
    }

    public function transformTypes(string $type): string
    {
        $oldTypes = [
            'LIKE' => 'like-of',
            'REPOST' => 'repost-of',
            'BOOKMARK' => 'bookmark-of',
            'REPLY' => 'in-reply-to',
            'RSVP' => 'rsvp',
            'MENTION' => 'mention-of',
            'INVITE' => 'invite',
            'KOMMENT' => 'comment',
            'SPAM' => 'comment',
        ];

        return $oldTypes[$type] ?? 'comment';
    }
}
