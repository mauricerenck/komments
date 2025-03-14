<?php

namespace mauricerenck\Komments;

use Kirby\Cms\Structure;
use Kirby\Toolkit\Collection;
use Kirby\Content\Content;
use Kirby\Toolkit\Obj;

class StoragePhpunit extends Storage
{

    private Collection $commentDatabase;

    public function __construct()
    {
        parent::__construct();
        $this->commentDatabase = new Collection();
    }

    public function getSingleComment(string $commentId): Content
    {
        $comment = $this->getCommentMock(['id' => $commentId]);
        $structuredComment = $this->convertToStructure($comment);
        return $structuredComment->first();
    }

    public function getCommentsOfPage(string $pageUuid): Structure
    {
        $comments = $this->getCommentCollection();
        $structuredComment = $this->convertToStructure($comments);
        return $structuredComment;
    }

    public function getCommentsOfSite(): Structure
    {
        $comments = $this->getCommentCollection();
        $structuredComment = $this->convertToStructure($comments);
        return $structuredComment;
    }

    public function saveComment(Content $comment): bool
    {
        $this->commentDatabase->append($comment);
    }


    public function updateComment(string $commentId, array $values): bool
    {
        $filteredComments = $this->commentDatabase->filterBy('id', $commentId);
        $filteredComment = $filteredComments->first();
        $newComment = $filteredComment->merge($values);

        $this->commentDatabase->remove($commentId);
        $this->commentDatabase->append($newComment);
    }

    public function deleteComment(string $commentId): bool
    {
        $this->commentDatabase->remove($commentId);
    }

    /**
     * @param array<Obj|Collection> $databaseResults
     * @return Collection
     */
    public function convertToStructure(Obj|Collection $databaseResults): Structure
    {
        $comments = [];
        $databaseResults = ($databaseResults instanceof Obj) ? [$databaseResults] : $databaseResults;

        foreach ($databaseResults as $databaseResult) {
            $comment = $this->createComment(
                id: $databaseResult->id,
                pageUuid: $databaseResult->page_uuid,
                parentId: $databaseResult->parent_id,
                type: $databaseResult->type,
                content: $databaseResult->content,
                authorName: $databaseResult->author_name,
                authorAvatar: $databaseResult->author_avatar,
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

    public function fillCommentDb(): void
    {
        $this->commentDatabase = $this->getCommentCollection();
    }

    private function getCommentMock(array $comment = []): Obj
    {
        $defaultComment = [
            'id' => 'comment-id',
            'pageUuid' => 'page://uzeaX0oDEG6ZYGKS', // phpunit page
            'parentId' => '',
            'type' => 'comment',
            'content' => 'lorem ipsum dolor sit amet.',
            'authorName' => 'Author Name',
            'authorAvatar' => 'https://api.dicebear.com/9.x/pixel-art/png?seed=AuthorName',
            'authorEmail' => 'author@example.com',
            'authorUrl' => 'https://example.com',
            'published' => true,
            'verified' => false,
            'spamlevel' => 0,
            'language' => null,
            'upvotes' => 0,
            'downvotes' => 0,
            'createdAt' => '2024-01-02 10:00:00',
            'updatedAt' => '2024-01-02 10:00:00',
        ];

        $comment = array_merge($defaultComment, $comment);

        return new Obj([
            'id' => $comment['id'],
            'page_uuid' => $comment['pageUuid'],
            'parent_id' => $comment['parentId'],
            'type' => $comment['type'],
            'content' => $comment['content'],
            'author_name' => $comment['authorName'],
            'author_avatar' => $comment['authorAvatar'],
            'author_email' => $comment['authorEmail'],
            'author_url' => $comment['authorUrl'],
            'published' => $comment['published'],
            'verified' => $comment['verified'],
            'spamlevel' => $comment['spamlevel'],
            'language' => $comment['language'],
            'upvotes' => $comment['upvotes'],
            'downvotes' => $comment['downvotes'],
            'created_at' => $comment['createdAt'],
            'updated_at' => $comment['updatedAt'],
            'permalink' => '/@/comment/' . $comment['id'],
        ]);
    }

    private function getCommentCollection(): Collection
    {
        $comments = [
            $this->getCommentMock(['id' => 'comment-id-1']),
            $this->getCommentMock(['id' => 'comment-id-2', 'published' => false]),
            $this->getCommentMock(['id' => 'comment-id-3', 'verified' => true]),
            $this->getCommentMock(['id' => 'comment-id-4', 'spamlevel' => 100]),
        ];

        return new Collection($comments);
    }
}
