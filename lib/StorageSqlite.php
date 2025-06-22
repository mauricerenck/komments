<?php

namespace mauricerenck\Komments;

use Kirby\Cms\Structure;
use Kirby\Toolkit\Collection;
use Kirby\Content\Content;
use Kirby\Toolkit\Obj;

class StorageSqlite extends Storage
{

    public function __construct(private ?DatabaseAbstraction $database = null, private ?string $sqlitePath = null)
    {
        parent::__construct();
        $this->sqlitePath = $sqlitePath ?? option('mauricerenck.komments.storage.sqlitePath', '.sqlite/');
        $this->database = $database ?? new DatabaseAbstraction($this->sqlitePath, 'komments.sqlite');
    }

    public function getSingleComment(string $commentId): Content
    {
        $comment = $this->database->select('comments', ['*'], 'WHERE id = "' . $commentId . '"')->first();

        if (!$comment) {
            return new Content([]);
        }

        $structuredComment = $this->convertToStructure($comment);
        return $structuredComment->first();
    }

    public function getCommentsOfPage(string $pageUuid): Structure
    {
        $comments = $this->database->select('comments', ['*'], 'WHERE page_uuid = "' . $pageUuid . '"');

        if (!$comments) {
            return new Structure([]);
        }

        $structuredComment = $this->convertToStructure($comments);
        return $structuredComment;
    }

    public function getCommentsOfSite(): Structure
    {
        $comments = $this->database->select('comments', ['*']);

        if (!$comments) {
            return new Structure([]);
        }

        $structuredComment = $this->convertToStructure($comments);
        return $structuredComment;
    }

    public function saveComment(Content $comment): bool
    {
        return $this->database->insert(
            'comments',
            ['id', 'page_uuid', 'parent_id', 'type', 'language', 'content', 'author_name', 'author_avatar', 'author_email', 'author_url', 'published', 'verified', 'spamlevel', 'upvotes', 'downvotes', 'created_at', 'updated_at'],
            [
                $comment->id(),
                $comment->pageUuid(),
                $comment->parentId(),
                $comment->type(),
                $comment->language(),
                $comment->content(),
                $comment->authorName(),
                $comment->authorAvatar(),
                $comment->authorEmail(),
                $comment->authorUrl(),
                $comment->published(),
                $comment->verified(),
                $comment->spamlevel(),
                $comment->upvotes(),
                $comment->downvotes(),
                $comment->createdAt(),
                $comment->createdAt()
            ]
        );
    }

    public function updateComment(string $commentId, array $values): bool
    {
        $fields = [];
        $newValues = [];

        foreach ($values as $key => $value) {
            $fields[] = $key;
            $newValues[] = $value;
        }

        return $this->database->update('comments', $fields, $newValues, 'WHERE id = "' . $commentId . '"');
    }

    public function publishPendingComments(): bool
    {
        return $this->database->update('comments', ['published'], [1], 'WHERE published != 1');
    }

    public function deleteComment(string $commentId): bool
    {
        return $this->database->delete('comments', 'WHERE id = "' . $commentId . '"');
    }

    public function deleteComments(string $type): bool
    {
        switch ($type) {
            case 'spam':
                return $this->database->delete('comments', 'WHERE published != 1 AND spamlevel > "0"');
            case 'pending':
                return $this->database->delete('comments', 'WHERE published != 1');
            default:
                return false;
        }
    }

    /**
     * @param array<Obj|Collection> $databaseResults
     * @return Collection
     */
    public function convertToStructure(Obj|Collection|Structure $databaseResults): Structure
    {
        $avatarHandler = new AvatarHandler();

        $comments = [];
        $databaseResults = ($databaseResults instanceof Obj) ? [$databaseResults] : $databaseResults;

        foreach ($databaseResults as $databaseResult) {
            $avatar = $avatarHandler->getAvatar($databaseResult->author_avatar, $databaseResult->author_name);

            $comment = $this->createComment(
                id: $databaseResult->id,
                pageUuid: $databaseResult->page_uuid,
                parentId: $databaseResult->parent_id,
                type: $databaseResult->type,
                content: $databaseResult->content,
                authorName: $databaseResult->author_name,
                authorAvatar: $avatar,
                authorEmail: $databaseResult->author_email,
                authorUrl: $databaseResult->author_url,
                published: $databaseResult->published,
                verified: $databaseResult->verified,
                spamlevel: $databaseResult->spamlevel,
                language: $databaseResult->language,
                upvotes: $databaseResult->upvotes,
                downvotes: $databaseResult->downvotes,
                createdAt: $databaseResult->created_at,
                updatedAt: $databaseResult->updated_at
            );

            $comments[] = $comment;
        }

        $collection = new Structure($comments);
        return $collection;
    }
}
