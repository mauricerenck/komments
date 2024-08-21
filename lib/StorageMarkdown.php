<?php

namespace mauricerenck\Komments;

use Kirby\Cms\Structure;
use Kirby\Content\Content;
use Kirby\Toolkit\Obj;
use Kirby\Toolkit\Collection;
use Kirby\Uuid\Uuid;

class StorageMarkdown extends Storage {

    public function __construct() {
        parent::__construct();
    }

    public function getSingleComment(string $commentId):Content {}

    public function getCommentsOfPage(string $pageUuid): Structure {
        $page = site()->find($pageUuid);

        if (is_null($page)) {
            return [];
        }

        $baseUtils = new KommentBaseUtils();
        $allPageInboxes = $baseUtils->getAllCommentsOfPage($page);

        if (is_null($allPageInboxes)) {
            return [];
        }

        return $allPageInboxes;
    }

    public function getCommentsOfSite(): Collection {
        $comments = [];
        $collection = site()->index();

        foreach ($collection as $item) {
            $comments = array_merge($comments, $this->getCommentsOfPage($item));
        }

        usort($comments, function ($a, $b) {
            return $b['published'] <=> $a['published'];
        });

        return $comments;
    }

    public function saveComment(Content $comment): bool {}

    public function updateComment(string $commentId, array $values): bool {}

    public function deleteComment(string $commentId): bool {}

    /**
     * @param array<Obj|Collection> $databaseResults
     * @return Collection
     */
    public function convertToStructure(Obj|Collection $databaseResults): Structure {}

    // FIXME hier wegwerfe, weil das schon in der parent class ist?
    public function createComment(
        string $id,
        string $pageUuid,
        string $parentId,
        string $type,
        string $content,
        string $authorName,
        string $authorAvatar,
        ?string $authorEmail,
        string $authorUrl,
        bool $published,
        bool $verified,
        int $spamlevel,
        ?string $language,
        int $upvotes,
        int $downvotes,
        string $createdAt,
        string | null $updatedAt
    ):Content {
        $uuid = Uuid::generate();

        return new Content([
            'id' => $uuid,
            'page_uuid' => $pageUuid,
            'parent_id' => $parentId,
            'type' => $type,
            'content' => $content,
            'author' => [
                'name' => $authorName,
                'avatar' => $authorAvatar,
                'email' => $authorEmail,
                'url' => $authorUrl,
            ],
            'status' => [
                'published' => $published,
                'verified' => $verified,
                'spamlevel' => $spamlevel,
            ],
            'reactions' => [
                'upvotes' => $upvotes,
                'downvotes' => $downvotes,
            ],
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ]);
    }
}
