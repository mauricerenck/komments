<?php

namespace mauricerenck\Komments;

use Kirby\Cms\Structure;
use Kirby\Content\Content;
use Kirby\Toolkit\Obj;
use Kirby\Toolkit\Collection;

class Storage {

    public function __construct() {}

    public function getSingleComment(string $commentId):Content {}

    public function getCommentsOfPage(string $pageUuid): Structure {}

    public function getCommentsOfSite(): Collection {}

    public function saveComment(Content $comment): bool {}

    public function updateComment(string $commentId, array $values): bool {}

    public function deleteComment(string $commentId): bool {}

    /**
     * @param array<Obj|Collection> $databaseResults
     * @return Collection
     */
    public function convertToStructure(Obj|Collection $databaseResults): Structure {}

    public function createComment(
        string $id,
        string $pageUuid,
        string $parentId,
        string $type,
        string $content,
        string $authorName,
        string $authorAvatar,
        string $authorEmail,
        string $authorUrl,
        bool $published,
        bool $verified,
        int $spamlevel,
        ?string $language,
        int $upvotes,
        int $downvotes,
        string $createdAt,
        string | null $updatedAt
    ): Content {

        return new Content([
            'id' => $id,
            'pageUuid' => $pageUuid,
            'parentId' => $parentId,
            'type' => $type,
            'content' => $content,
            'authorName' => $authorName,
            'authorAvatar' => $authorAvatar,
            'authorEmail' => $authorEmail,
            'authorUrl' => $authorUrl,
            'published' => $published,
            'verified' => $verified,
            'spamlevel' => $spamlevel,
            'language' => $language,
            'upvotes' => $upvotes,
            'downvotes' => $downvotes,
            'createdAt' => $createdAt,
            'updatedAt' => $updatedAt,
            'permalink' => '/@/comment/' . $id,
        ]);
    }
}
