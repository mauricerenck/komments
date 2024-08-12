<?php

namespace mauricerenck\Komments;

use Exception;
use Kirby\Data\Yaml;

class KommentModeration
{
    // TODO write tests
    public function markAsSpam($pageSlug, $kommentId, $isSpam)
    {
        $baseUtils = new KommentBaseUtils();
        $targetPage = $baseUtils->getPageFromSlug($pageSlug);

        if (!$targetPage) {
            throw new Exception('Page not found', 404);
        }

        $newData = [
            'status' => false,
            'verified' => false,
            'spamlevel' => 100,
        ];

        $baseUtils->updateSingleComment($targetPage, $kommentId, $newData);
    }

    // TODO write tests
    public function markAsVerified($pageSlug, $kommentId, $isVerified)
    {
        try {
            $baseUtils = new KommentBaseUtils();
            $targetPage = $baseUtils->getPageFromSlug($pageSlug);

            if (!$targetPage) {
                throw new Exception('Page not found', 1);
            }

            $fieldData = $baseUtils->getAllCommentsOfPage($targetPage);
            $fieldData = $fieldData->toArray();

            for ($i = 0; $i < count($fieldData); $i++) {
                if (isset($fieldData[$i]['id'])) {
                    // backward compatibility
                    if ($fieldData[$i]['id'] === $kommentId) {
                        $fieldData[$i]['verified'] = $isVerified;
                    }
                }
            }

            $fieldData = Yaml::encode($fieldData);

            $kirby = kirby();
            $kirby->impersonate('kirby');
            $targetPage->update([
                'kommentsInbox' => $fieldData,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // TODO write tests
    public function publish($pageSlug, $kommentId, $publish)
    {
        try {
            $baseUtils = new KommentBaseUtils();
            $targetPage = $baseUtils->getPageFromSlug($pageSlug);

            if (!$targetPage) {
                throw new Exception('Page not found', 1);
            }

            $fieldData = $baseUtils->getAllCommentsOfPage($targetPage);
            $fieldData = $fieldData->toArray();

            for ($i = 0; $i < count($fieldData); $i++) {
                if (isset($fieldData[$i]['id'])) {
                    // backward compatibility
                    if ($fieldData[$i]['id'] === $kommentId) {
                        $fieldData[$i]['status'] = $publish;
                    }
                }
            }

            $fieldData = Yaml::encode($fieldData);

            $kirby = kirby();
            $kirby->impersonate('kirby');
            $targetPage->update([
                'kommentsInbox' => $fieldData,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // TODO write tests
    public function delete($pageSlug, $kommentId)
    {
        try {
            $baseUtils = new KommentBaseUtils();
            $targetPage = $baseUtils->getPageFromSlug($pageSlug);

            if (!$targetPage) {
                throw new Exception('Page not found', 1);
            }

            $fieldData = $baseUtils->getAllCommentsOfPage($targetPage);
            $fieldData = $fieldData->toArray();
            $newFieldData = [];

            for ($i = 0; $i < count($fieldData); $i++) {
                if (isset($fieldData[$i]['id'])) {
                    // backward compatibility
                    if ($fieldData[$i]['id'] !== $kommentId) {
                        $newFieldData[] = $fieldData[$i];
                    }
                }
            }

            $newFieldData = Yaml::encode($newFieldData);

            $kirby = kirby();
            $kirby->impersonate('kirby');
            $targetPage->update([
                'kommentsInbox' => $newFieldData,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // TESTING NOT POSSIBLE RIGHT NOW
    public function getComments(?bool $published = false, ?string $type = 'comment'): mixed
    {
        $storage = StorageFactory::create();
        $comments = $storage->getCommentsOfSite();
        $filteredComments = $comments->filterBy('published', $published)->filterBy('type', $type)->sortBy('updatedAt','desc');

        $pages = [];

        foreach ($filteredComments as $comment) {
            $uuid = $comment->pageuuid()->value();
            $page = page($uuid);

            $pages[] = [
                'uuid' => $uuid,
                'title' => $page->title()->value(),
                'panel' => $page->panel()->url()
            ];
        }

        return [
            'comments' => $filteredComments->toJson(),
            'affectedPages' => $pages
        ];

    }

    // TESTED
    public function getCommentsOfPage($page, $filter = null, $language = null)
    {
        $baseUtils = new KommentBaseUtils();
        $allPageInboxes = $baseUtils->getAllCommentsOfPage($page);

        if (is_null($allPageInboxes)) {
            return [];
        }

        $filteredComments = $baseUtils->filterCommentsByStatus($allPageInboxes, $filter);

        return $this->convertInboxToCommentArray($filteredComments, $page);
    }

    // TESTED
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
