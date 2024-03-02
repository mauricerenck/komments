<?php

namespace mauricerenck\Komments;

use Kirby\Cms\Structure;

class KommentsFrontend
{
    private $baseUtils;

    public function __construct(private ?int $expireAfterNumOfDays = null, private ?string $dateField = null)
    {
        $this->baseUtils = new KommentBaseUtils();

        $this->expireAfterNumOfDays = $expireAfterNumOfDays ?? option('mauricerenck.komments.auto-disable-komments', 0);
        $this->dateField = $dateField ?? option('mauricerenck.komments.auto-disable-komments-datefield', 'date');
    }

    public function kommentsAreExpired($page)
    {
        if ($this->expireAfterNumOfDays === 0) {
            return false;
        }

        $dateFieldName = $this->dateField;

        if (is_null($page->$dateFieldName()) || $page->$dateFieldName()->exists() === false) {
            return false;
        }

        $publishDate = $page->$dateFieldName()->toDate();

        if ($publishDate === 0) {
            return false;
        }

        $now = time();

        if ($now - $publishDate > $this->expireAfterNumOfDays * 24 * 60 * 60) {
            return true;
        }

        return false;
    }

    // TODO write tests
    public function getCommentList($page): array
    {
        $inboxes = $this->baseUtils->getAllCommentsOfPage($page);

        $commentList = [
            'likes' => new Structure(),
            'reposts' => new Structure(),
            'replies' => new Structure(),
            'mentions' => new Structure(),
            'comments' => new Structure(),
        ];

        $filteredInbox = $this->baseUtils->filterCommentsByType($inboxes, 'LIKE');
        if ($filteredInbox->count() > 0) {
            $commentList['likes']->add($filteredInbox);
        }

        $filteredInbox = $this->baseUtils->filterCommentsByType($inboxes, 'REPOST');
        if ($filteredInbox->count() > 0) {
            $commentList['reposts']->add($filteredInbox);
        }

        $filteredInbox = $this->baseUtils->filterCommentsByType($inboxes, 'MENTION');
        if ($filteredInbox->count() > 0) {
            $commentList['mentions']->add($filteredInbox);
        }

        $filteredInbox = $this->baseUtils->filterCommentsByType($inboxes, 'REPLY');
        if ($filteredInbox->count() > 0) {
            $commentList['replies']->add($filteredInbox);
        }

        $filteredInbox = $this->baseUtils->filterCommentsByType($inboxes, 'KOMMENT');
        if ($filteredInbox->count() > 0) {
            $commentList['comments']->add($filteredInbox);
        }

        return $commentList;
    }

    // FIXME deprecated ?
    public function convertToNestedComments($comments)
    {
        $nestedComments = [];
        foreach ($comments as $comment) {
            $nestedComments[$comment['id']] = $comment;
        }

        foreach ($nestedComments as $reply) {
            $mentionOf = $reply['mentionof'];
            if (!empty($nestedComments[$mentionOf])) {
                $nestedComments[$mentionOf]['replies'][] = $reply['id'];
            }
        }

        return $this->buildTree($nestedComments);
    }

    // FIXME deprecated ?
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

    private function transformToReply($komment)
    {
        deprecated('`transformToReply()` is deprecated. `transformToReply()` will be removed in future versions.');
    }
}
