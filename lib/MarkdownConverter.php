<?php

namespace mauricerenck\Komments;

use Kirby\Cms\Structure;
use Kirby\Toolkit\Collection;
use Kirby\Uuid\Uuid;
use Kirby\Toolkit\Obj;

class MarkdownConverter
{

    public function __construct(private ?array $languageCodes = null)
    {
        $this->languageCodes = $languageCodes;
    }

    public function getAllLanguages()
    {
        // this method is used for easy mocking in tests
        if (!is_null($this->languageCodes)) {
            return $this->languageCodes;
        }

        if (!kirby()->multilang()) {
            return [null];
        }

        $languages = kirby()->languages();

        $languageCodes = [];
        foreach ($languages as $language) {
            $languageCodes[] = $language->code();
        }

        return $languageCodes;
    }

    public function getInboxByLanguage($page, $language = null)
    {
        if (is_null($language)) {
            return $page->kommentsInbox();
        }

        if (is_string($language)) {
            return $page->content($language)->kommentsInbox();
        }

        return null;
    }

    public function getCommentsOfPage(string $pageUuid): Structure
    {
        $page = site()->find($pageUuid);

        if (is_null($page)) {
            return [];
        }

        $allPageInboxes = $this->getAllCommentsOfPage($page);

        if (is_null($allPageInboxes)) {
            return [];
        }

        return $allPageInboxes;
    }

    public function getAllCommentsOfPage($page)
    {
        $languageCodes = $this->getAllLanguages();
        $inboxes = new Structure();

        if (count($languageCodes) === 0) {
            $inbox = $this->getInboxByLanguage($page);
            if (!is_null($inbox)) {
                $inboxes->add($inbox->toStructure());
            }

            return $inboxes;
        }

        foreach ($languageCodes as $language) {
            $inbox = $this->getInboxByLanguage($page, $language);
            if (!is_null($inbox)) {
                $inboxes->add($inbox->toStructure());
            }
        }

        return $inboxes;
    }

    public function getCommentsOfSite(): Collection
    {
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

    /**
     * @param array<Obj|Collection> $databaseResults
     * @return Collection
     */
    public function convertToNewFormat(Obj|Collection $markdownResults)
    {
        $storageMarkdown = new StorageMarkdown();

        foreach ($markdownResults as $oldComment) {
            $id = $oldComment->id() ?? Uuid::generate();
            $parentId = V::url($oldComment->mentionof()) ? '' : $oldComment->mentionof();

            if ($id == 0) {
                $id = Uuid::generate();
            }

            $comment = $this->createComment(
                id: $id,
                pageUuid: $databaseResult->page_uuid,
                parentId: $parentId,
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
        }
    }
}
