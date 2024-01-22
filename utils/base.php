<?php

namespace mauricerenck\Komments;

use json_decode;
use Structure;
use f;
use Kirby\Http\Remote;

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

    public function kommentsAreExpired($page)
    {
        $expireAfterNumOfDays = option('mauricerenck.komments.auto-disable-komments', 0);

        if ($expireAfterNumOfDays === 0) {
            return false;
        }

        $dateField = option('mauricerenck.komments.auto-disable-komments-datefield', 'date');
        $publishDate = $page->$dateField()->toDate();
        $now = time();

        if (($now - $publishDate) > $expireAfterNumOfDays * 24 * 60 * 60) {
            return true;
        }

        return false;
    }

    public function parseKomments($komments)
    {
        $structuredKomments = ['replies' => [], 'reposts' => [], 'mentions' => [], 'likes' => []];
        $replies = [];
        $replyTree = [];
        $komments = $komments->toStructure();

        foreach ($komments as $komment) {
            if ($komment->status()->isTrue()) {
                switch ($komment->kommenttype()->raw()) {
                    case 'LIKE':
                        $structuredKomments['likes'][] = $komment;
                        break;
                    case 'REPOST':
                        $structuredKomments['reposts'][] = $komment;
                        break;
                    case 'MENTION':
                        $structuredKomments['mentions'][] = $komment;
                        break;
                    default:
                        $replyTree[$komment->id()] = $this->transformToReply($komment);
                        break;
                }
            }
        }

        foreach ($replyTree as $reply) {
            $mentionOf = $reply['mentionof'];
            if (!empty($replyTree[$mentionOf])) {
                $replyTree[$mentionOf]['replies'][] = $reply['id'];
            }
        }

        $structuredKomments['replies'] = $this->buildTree($replyTree);

        return $structuredKomments;
    }

    public function buildTree($flatArray)
    {
        $tree = [];

        foreach ($flatArray as $key => $flat) {
            $nodes = [];
            $tree = [];
            foreach ($flatArray as $key => &$node) {
                $node['replies'] = [];
                $id = $node['id'];
                $parent_id = $node['mentionof'];
                $nodes[$id] = &$node;
                if (array_key_exists($parent_id, $nodes)) {
                    $nodes[$parent_id]['replies'][] = &$node;
                } else {
                    $tree[] = &$node;
                }
            }
        }
        return $tree;
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

    public function getCommentsOfPage($page, $filter = 'all')
    {
        if ($page->kommentsInbox()->isEmpty()) {
            return [];
        }

        $comments = [];
        $allPageComments = $page->kommentsInbox()->toStructure();
        $filteredComments = [];

        switch($filter) {
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

        foreach ($filteredComments as $komment) {
            $comments[] = [
                'id' => $komment->id(),
                'slug' => $page->id(),
                'author' => $komment->author()->value(),
                'authorUrl' => $komment->authorUrl()->value(),
                'komment' => kirbytext(nl2br(html($komment->komment()))),
                'kommentType' => $komment->kommenttype()->value() ?? 'komment',
                'image' => $komment->avatar()->value(),
                'title' => $page->title()->value(),
                'url' => $page->panel()->url(),
                'published' => date('Y-m-d H:i', strtotime($komment->published())),
                'verified' => $komment->verified()->toBool(false),
                'spamlevel' => $komment->spamlevel()->value() ?? 0,
                'status' => $komment->status()->toBool(false),
            ];
        }

        return $comments;
    }

    public function getCommentsCountOfPage($page, $filter = 'all'): int
    {
        if ($page->kommentsInbox()->isEmpty()) {
            return 0;
        }

        $allPageComments = $page->kommentsInbox()->toStructure();
        $filteredComments = [];

        switch($filter) {
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

    private function transformToReply($komment)
    {
        return [
            'id' => $komment->id(),
            'avatar' => $komment->avatar()->value(),
            'author' => $komment->author()->value(),
            'authorurl' => $komment->authorUrl()->value(),
            'source' => $komment->source()->value(),
            'target' => $komment->target()->value(),
            'mentionof' => $komment->mentionOf()->value(),
            'property' => $komment->property()->value(),
            'komment' => $komment->komment(),
            'quote' => $komment->quote(),
            'kommenttype' => $komment->kommenttype()->value(),
            'published' => $komment->published(),
            'status' => $komment->status()->value(),
            'wmsource' => $komment->wmsource()->value(),
            'wmtarget' => $komment->wmtarget()->value(),
            'wmproperty' => $komment->wmproperty()->value(),
            'verified' => $komment->verified()->value(),
            'replies' => []
        ];
    }
}
