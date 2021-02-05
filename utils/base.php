<?php

namespace mauricerenck\Komments;

use json_encode;
use json_decode;
use in_array;

class KommentBaseUtils
{
    // public function __construct()
    // {
    // }

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
                    case 'LIKE': $structuredKomments['likes'][] = $komment; break;
                    case 'REPOST': $structuredKomments['reposts'][] = $komment; break;
                    case 'MENTION': $structuredKomments['mentions'][] = $komment; break;
                    default: $replyTree[$komment->id()] = $this->transformToReply($komment); break;
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
            'replies' => []
        ];
    }
}
