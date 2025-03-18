<?php

namespace mauricerenck\Komments;

use Kirby\Filesystem\Dir;
use Kirby\Filesystem\F;
use Kirby\Toolkit\V;
use Kirby\Uuid\Uuid;
use Kirby\Content\Content;

class Migrations
{
    public function __construct(
        private ?string $storageType = null,
        private ?string $sqlitePath = null,
        private ?bool $disableMigrations = null,
    ) {
        $this->storageType = $storageType ?? option('mauricerenck.komments.storage.type', 'sqlite');
        $this->sqlitePath = $sqlitePath ?? option('mauricerenck.komments.storage.sqlitePath', '.sqlite/');
        $this->disableMigrations = $disableMigrations ?? option('mauricerenck.komments.migrations.disabled', false);
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
            }
        }
    }

    public function getListOfAllComments()
    {
        $commentList = [];
        $pageList = site()->index();

        $markdownConverter = new MarkdownConverter();
        $languageCodes = $markdownConverter->getAllLanguages();

        foreach ($pageList as $page) {
            $knownCommentIds = [];

            foreach ($languageCodes as $language) {
                $inbox = $markdownConverter->getInboxByLanguage($page, $language);

                if (!is_null($inbox)) {
                    foreach ($inbox->toStructure() as $comment) {
                        if (in_array($comment->id(), $knownCommentIds)) {
                            continue;
                        }

                        $knownCommentIds[] = $comment->id();
                        $commentList[] = [
                            'pageUuid' => $page->uuid()->id(),
                            'pageTitle' => $page->title()->value(),
                            'comment' => $comment->toArray(),
                            'language' => $language,
                        ];
                    }
                }
            }
        }

        return $commentList;
    }

    public function convertSingleComment($comment, $language, $uuid): array
    {
        switch ($this->storageType) {
            case 'sqlite':
                $storage = new StorageSqlite();
                break;
            case 'markdown':
                $storage = new StorageMarkdown();
                break;
        }

        try {
            $transformedComment = $this->convertCommentToNewFormat($comment, $language, $uuid, $storage);
            $storage->saveComment($transformedComment);

            return [
                'status' => 'success',
                'pageUuid' => $uuid,
                'comment' => $transformedComment->id()->value(),
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'failed',
                'pageUuid' => $uuid,
                'comment' => null,
            ];
        }
    }

    public function convertComments(): void
    {
        $allComments = $this->getListOfAllComments();

        foreach ($allComments as $comment) {
            $result = $this->convertSingleComment(comment: $comment['comment'], language: $comment['language'], uuid: $comment['pageUuid']);
            echo $result['comment'] . ' ' . $result['status'] . ' ' . $result['pageUuid'] . PHP_EOL;
            flush();
        }
    }

    public function convertCommentToNewFormat($comment, ?string $language, string $pageUuid, $storage): Content
    {
        $id = $comment['id'] ?? Uuid::generate();
        $parentId = V::url($comment['mentionof']) ? '' : $comment['mentionof'] ?? '';

        if ($id == 0) {
            $id = Uuid::generate();
        }

        return $storage->createComment(
            id: $id,
            pageUuid: 'page://' . $pageUuid,
            parentId: $parentId,
            type: $this->transformTypes($comment['kommenttype']),
            content: $comment['komment'],
            authorName: $comment['author'],
            authorAvatar: $comment['avatar'],
            authorEmail: $comment['authoremail'],
            authorUrl: $comment['authorurl'],
            published: $comment['status'] == 'true' ? true : false,
            verified: $comment['verified'] == 'true' ? true : false,
            spamlevel: $comment['spamlevel'] ?? 0,
            language: $language,
            upvotes: 0,
            downvotes: 0,
            createdAt: $comment['published'],
            updatedAt: $comment['published'],
        );
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
