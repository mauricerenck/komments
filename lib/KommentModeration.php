<?php

namespace mauricerenck\Komments;

class KommentModeration
{
    public function getComment(string $id): mixed
    {
        $storage = StorageFactory::create();
        $comment = $storage->getSingleComment($id);
        $pages = [];


        $uuid = $comment->pageuuid()->value();
        $page = page($uuid);

        $pages[] = [
            'uuid' => $uuid,
            'title' => $page->title()->value(),
            'panel' => $page->panel()->url()
        ];


        return $comment->toArray();
    }

    public function deleteComment(string $id): mixed
    {
        $storage = StorageFactory::create();
        $result = $storage->deleteComment($id);
        return $result;
    }

    public function publishComment(string $id): mixed
    {
        $storage = StorageFactory::create();
        $comment = $storage->getSingleComment($id);
        $newStatus = $comment->published()->isTrue() ? false : true;
        $result = $storage->updateComment($id, ['published' => $newStatus]);
        return $result ? $newStatus : $comment->published();
    }

    public function flagComment(string $id, string $flag): mixed
    {
        $storage = StorageFactory::create();
        $comment = $storage->getSingleComment($id);

        switch($flag) {
            case 'spamlevel':
                if($comment->spamlevel()->value() > 0) {
                    return $storage->updateComment($id, ['spamlevel' => 0]) ? 0 : $comment->spamlevel();
                }
                else {
                    return ($storage->updateComment($id, ['spamlevel' => 100, 'published' => false, 'verified' => false])) ? 100 : $comment->spamlevel();
                }
            case 'verified':
                if($comment->verified()->isTrue()) {
                    return $storage->updateComment($id, ['verified' => false]) ? false : $comment->verified();
                }
                else {
                    return $storage->updateComment($id, ['spamlevel' => 0, 'verified' => true]) ? true : $comment->verified();
                }
        }

        return false;
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
}