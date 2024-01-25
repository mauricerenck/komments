<?php

namespace mauricerenck\Komments;

class KommentBaseUtils
{
    public function getPageFromSlug(string $pageSlug)
    {
        $page = page($pageSlug);
        if (is_null($page)) {
            return false;
        }

        return $page;
    }

    public function getPendingKomments(): array
    {
        $pendingComments = [];
        $collection = site()->index();

        foreach ($collection as $item) {
            $pendingComments = array_merge($pendingComments, $this->getCommentsOfPage($item, 'pending'));
        }

        usort($pendingComments, function ($a, $b) {
            return $b['published'] <=> $a['published'];
        });

        return $pendingComments;
    }

    public function getCommentsOfPage($page, $filter = null, $language = null)
    {
        $allPageInboxes = $this->getInboxByLanguage($page, $language);
        $allPageComments = $allPageInboxes->toStructure();

        if (is_null($allPageComments)) {
            return [];
        }

        $filteredComments = [];

        switch ($filter) {
            case 'published':
                $filteredComments = $allPageComments->filterBy('status', 'true');
                break;
            case 'pending':
                $filteredComments = $allPageComments->filterBy('status', 'false');
                break;
            case 'spam':
                $filteredComments = $allPageComments->filterBy('spamlevel', '!=', '0');
                break;
            default:
                $filteredComments = $allPageComments;
                break;
        }


        return $this->convertInboxToCommentArray($filteredComments, $page);
    }

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

    public function getCommentsCountOfPage($page, $filter = 'all'): int
    {
        if ($page->kommentsInbox()->isEmpty()) {
            return 0;
        }

        $allPageComments = $page->kommentsInbox()->toStructure();
        $filteredComments = [];

        switch ($filter) {
            case 'published':
                $filteredComments = $allPageComments->filterBy('status', 'true');
                break;
            case 'pending':
                $filteredComments = $allPageComments->filterBy('status', 'false');
                break;
            case 'spam':
                $filteredComments = $allPageComments->filterBy('spamlevel', '!=', '0');
                break;
            default:
                $filteredComments = $allPageComments;
                break;
        }

        return $filteredComments->count();
    }

    public function getPendingCommentCount(): int
    {
        $collection = site()->index();
        $pendingKomments = 0;

        foreach ($collection as $item) {
            $pendingKomments += $this->getCommentsCountOfPage($item, 'pending');
        }

        return $pendingKomments;
    }

    public function getSpamCommentCount(): int
    {
        $collection = site()->index();
        $spamComments = 0;

        foreach ($collection as $item) {
            $spamComments += $this->getCommentsCountOfPage($item, 'spam');
        }

        return $spamComments;
    }

    public function convertInboxToCommentArray($inbox, $page)
    {
        $comments = [];

        foreach ($inbox as $entry) {
            $comments[] = [
                'id' => $entry->id(),
                'slug' => $page->id(),
                'author' => $entry->author()->value(),
                'authorUrl' => $entry->authorUrl()->value(),
                'komment' => kirbytext(nl2br(html($entry->komment()))),
                'kommentType' => $entry->kommenttype()->value() ?? 'komment',
                'image' => $entry->avatar()->value(),
                'title' => $page->title()->value(),
                'url' => $page->panel()->url(),
                'published' => date('Y-m-d H:i', strtotime($entry->published())),
                'verified' => $entry->verified()->toBool(false),
                'spamlevel' => $entry->spamlevel()->value() ?? 0,
                'status' => $entry->status()->toBool(false),
                'mentionof' => $entry->mentionof()->value() ?? null,
                'replies' => [],
            ];
        }

        return $comments;
    }
}
