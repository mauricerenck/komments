<?php

namespace mauricerenck\Komments;

use Kirby\Cms\Structure;
use Kirby\Toolkit\Collection;
use Kirby\Content\Content;
use Kirby\Toolkit\Obj;
use Kirby\Data\Yaml;
use Kirby\Cms\Page;

class StorageMarkdown extends Storage
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getSingleComment(string $commentId): Content
    {
        $comments = $this->getCommentsOfSite();

        if (is_null($comments)) {
            return new Content([]);
        }

        $comment = array_filter($comments->toArray(), function ($comment) use ($commentId) {
            return $comment['id'] === $commentId;
        });

        if (is_null($comment)) {
            return new Content([]);
        }

        $comment = reset($comment);
        return new Content($comment);
    }

    public function getCommentsOfPage(string $pageUuid): Structure
    {
        $page = page($pageUuid);
        if (is_null($page)) {
            return new Structure([]);
        }

        return $page->kommentsInboxData()->toStructure();
    }

    public function getCommentsOfSite(): Structure
    {
        $comments = [];
        $collection = site()->index();

        foreach ($collection as $page) {
            $comments[] = $this->getCommentsOfPage($page);
        }

        return new Structure($comments);
    }

    public function saveComment(Content $comment): bool
    {
        $page = page($comment->pageUuid());

        if (!$page) {
            return false;
        }

        if ($page->kommentsInboxData()->isNotEmpty()) {
            $fieldData = $page->kommentsInboxData()->yaml();
        }

        $fieldData[] = $comment->toArray();
        $fieldData = Yaml::encode($fieldData);

        $this->saveToFile($fieldData, $page);

        return true;
    }

    public function updateComment(string $commentId, array $values): bool
    {
        $page = $this->findPageOfComment($commentId);

        if (is_null($page)) {
            return false;
        }

        $comments = $page->kommentsInboxData()->yaml();

        foreach ($comments as $key => $comment) {
            if ($comment['id'] === $commentId) {
                $comments[$key] = array_merge($comment, $values);
            }
        }

        $fieldData = Yaml::encode($comments);
        $this->saveToFile($fieldData, $page);

        return true;
    }

    public function publishPendingComments(): bool // FIXME
    {
        throw new \Exception('Not implemented: Batch publishing pending comments when using markdown storage is not supported yet');
    }

    public function deleteComment(string $commentId): bool
    {
        $page = $this->findPageOfComment($commentId);

        if (is_null($page)) {
            return false;
        }

        $filteredComments = array_filter($page->kommentsInboxData()->yaml(), function ($comment) use ($commentId) {
            return $comment['id'] !== $commentId;
        });

        $fieldData = Yaml::encode($filteredComments);

        $this->saveToFile($fieldData, $page);
        return true;
    }


    public function deleteComments(string $type): bool // FIXME
    {
        throw new \Exception('Not implemented: Batch deleting comments when using markdown storage is not supported yet');
    }


    public function findPageOfComment(string $commentId): ?Page
    {
        $comments = $this->getCommentsOfSite();

        if (is_null($comments)) {
            return null;
        }

        foreach ($comments as $comment) {
            if ($comment->id() === $commentId) {
                return page($comment->pageUuid());
            }
        }

        return null;
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
                status: $databaseResult->status,
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

    public function saveToFile(string $fieldData, $page): void
    {
        $kirby = kirby();
        $kirby->impersonate('kirby');
        $page->update([
            'kommentsInboxData' => $fieldData
        ]);
    }

    public function saveVerificationToken(string $hash, string $commentId, string $expiresAt): bool
    {
        return false;
    }

    public function getVerificationToken(string $hash): Collection
    {
        return new Collection();
    }

    public function getVerificationTokens(): Collection
    {
        return new Collection();
    }

    public function deleteVerificationToken(string $hash): bool
    {
        return false;
    }

    public function cleanupVerificationTokens(string $deletionMode): bool
    {
        return false;
    }
}
