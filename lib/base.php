<?php

namespace mauricerenck\Komments;

use Kirby\Cms\Structure;
use Kirby\Data\Yaml;

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
        // this method is used for easy mocking in tests
        if (!is_null($this->languageCodes)) {
            return $this->languageCodes;
        }

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

    public function updateSingleComment($page, string $kommentId, array $newValues): bool
    {
        $languageCodes = $this->getAllLanguages();

        if (count($languageCodes) === 0) {
            $inbox = $this->getInboxByLanguage($page);
            if (!is_null($inbox)) {
                $inbox = $inbox->toArray();

                foreach ($inbox as $key => $komment) {
                    if ($komment['id'] === $kommentId) {
                        $inbox[$key] = array_merge($komment, $newValues);
                    }
                }
            }
        }

        foreach ($languageCodes as $language) {
            $inbox = $this->getInboxByLanguage($page, $language);
            if (!is_null($inbox)) {
                $inbox = $inbox->toArray();

                foreach ($inbox as $key => $komment) {
                    if ($komment['id'] === $kommentId) {
                        $inbox[$key] = array_merge($komment, $newValues);
                    }
                }
            }
        }

        $kirby = kirby();
        $kirby->impersonate('kirby');
        $newInbox = Yaml::encode($inbox);
        $page->update([
            'kommentsInbox' => $newInbox,
        ]);

        return true;
    }
}
