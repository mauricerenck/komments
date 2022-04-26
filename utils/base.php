<?php

namespace mauricerenck\Komments;

use json_encode;
use json_decode;
use in_array;
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

    public function getPluginVersion()
    {
        try {
            $composerString = f::read(__DIR__ . '/../composer.json');
            $composerJson = json_decode($composerString);

            $packagistResult = Remote::get('https://repo.packagist.org/p2/mauricerenck/komments.json');
            $packagistJson = json_decode($packagistResult->content());
            $latestVersion = $packagistJson->packages->{'mauricerenck/komments'}[0]->version;

            return [
                'local' => $composerJson->version,
                'latest' => $latestVersion,
                'updateAvailable' => $composerJson->version !== $latestVersion,
                'error' => false
            ];
        } catch (\Throwable $th) {
            throw 'Could not get package information';
            return[
                'local' => '',
                'latest' => '',
                'updateAvailable' => false,
                'error' => true
            ];
        }
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
        $pendingKomments = [];
        $collection = site()->index();
        $komments = new Structure();
        $key = 0;

        foreach ($collection as $item) {
            if ($item->kommentsInbox()->isNotEmpty()) {
                foreach ($item->kommentsInbox()->yaml() as $komment) {
                    $komment['spamlevel'] = (isset($komment['spamlevel'])) ? $komment['spamlevel'] : 0; // backward compatiblity
                    if (($komment['status'] === 'false' || $komment['status'] === false)) {
                        $pendingKomments[] = [
                            'id' => $komment['id'],
                            'slug' => $item->id(),
                            'author' => $komment['author'],
                            'authorUrl' => $komment['authorurl'],
                            'komment' => kirbytext(nl2br(html($komment['komment']))),
                            'kommentType' => (isset($komment['kommenttype'])) ? $komment['kommenttype'] : 'komment', // backward compatiblity
                            'image' => $komment['avatar'],
                            'title' => (string) $item->title(),
                            'url' => $item->panelUrl(),
                            'published' => date('Y-m-d H:i', strtotime($komment['published'])),
                            'verified' => ($komment['verified'] === true || $komment['verified'] === 'true') ? true : false,
                            'spamlevel' => $komment['spamlevel'],
                            'status' => ($komment['status'] === true || $komment['status'] === 'true') ? true : false,
                        ];
                    }
                }
            }
        }

        usort($pendingKomments, function ($a, $b) {
            return $b['published'] <=> $a['published'];
        });

        return $pendingKomments;
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
