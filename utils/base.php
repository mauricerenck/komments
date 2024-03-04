<?php

namespace mauricerenck\Komments;

use Kirby\Cms\Structure;

class KommentBaseUtils
{
    public function __construct(private ?array $languageCodes = null)
    {
        $this->languageCodes = $languageCodes;
    }

    // TESTED
    public function getPageFromSlug(string $pageSlug)
    {
        $page = page($pageSlug);
        if (is_null($page)) {
            return false;
        }

        return $page;
    }

    // NO NEED TO TEST
    public function getAllLanguages()
    {
        if (!is_null($this->languageCodes)) {
            return $this->languageCodes;
        }

        // this method is used for easy mocking in tests
        $languages = kirby()->languages();

        $languageCodes = [];
        foreach ($languages as $language) {
            $languageCodes[] = $language->code();
        }

        return $languageCodes;
    }

    // TESTED
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

    // TESTED
    public function filterCommentsByType($inbox, $type = 'all')
    {
        if ($type === 'all') {
            return $inbox;
        }

        return $inbox->filterBy('kommentType', $type);
    }

    // TESTED
    public function filterCommentsByStatus($inbox, $status = 'all')
    {
        switch ($status) {
            case 'published':
                return $inbox->filterBy('status', 'true');
            case 'pending':
                return $inbox->filterBy('status', 'false');
            case 'spam':
                return $inbox->filterBy('spamlevel', '!=', '0');
            default:
                return $inbox;
        }
    }

    // TESTED
    public function getInboxByLanguage($page, $language = null)
    {
        if ($page->kommentsInbox()->isEmpty()) {
            return null;
        }

        if (is_null($language)) {
            return $page->kommentsInbox();
        }

        if (is_string($language)) {
            return $page->content($language)->kommentsInbox();
        }

        return null;
    }

    // TESTED
    public function getCommentsCountOfPage($page, $filter = 'all'): int
    {
        $inbox = $this->getAllCommentsOfPage($page);
        $filteredInbox = $this->filterCommentsByStatus($inbox, $filter);

        return $filteredInbox->count();
    }

    // TODO TEST NOT POSSIBLE
    public function getSiteWideCommentCount(?string $filter = 'all'): int
    {
        $collection = site()->index();
        $pendingKomments = 0;

        foreach ($collection as $item) {
            $pendingKomments += $this->getCommentsCountOfPage($item, $filter);
        }

        return $pendingKomments;
    }
}
