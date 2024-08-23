<?php

namespace mauricerenck\Komments;

use Kirby\Uuid\Uuid;

class KommentModeration
{
    private $storage;

    public function __construct(private ?string $storageType = null)
    {
        $this->storage = StorageFactory::create($storageType);
    }

    public function getComment(string $id): mixed
    {
        $comment = $this->storage->getSingleComment($id);
        return $comment->toArray();
    }

    public function deleteComment(string $id): mixed
    {
        $result = $this->storage->deleteComment($id);
        return $result;
    }

    public function publishComment(string $id): mixed
    {
        $comment = $this->storage->getSingleComment($id);
        $newStatus = $comment->published()->isTrue() ? false : true;
        $result = $this->storage->updateComment($id, ['published' => $newStatus]);
        return $result ? $newStatus : $comment->published();
    }

    public function flagComment(string $id, string $flag): mixed
    {
        $comment = $this->storage->getSingleComment($id);

        switch($flag) {
            case 'spamlevel':
                if($comment->spamlevel()->toInt() > 0) {
                    return $this->storage->updateComment($id, ['spamlevel' => 0]) ? 0 : $comment->spamlevel();
                }
                else {
                    return ($this->storage->updateComment($id, ['spamlevel' => 100, 'published' => false, 'verified' => false])) ? 100 : $comment->spamlevel();
                }
            case 'verified':
                if($comment->verified()->isTrue()) {
                    return $this->storage->updateComment($id, ['verified' => false]) ? false : $comment->verified();
                }
                else {
                    return $this->storage->updateComment($id, ['spamlevel' => 0, 'verified' => true]) ? true : $comment->verified();
                }
        }

        return false;
    }

    public function replyToComment(string $id, array $formData) {

        $comment = $this->storage->getSingleComment($id);

        $publishResult = $comment->published()->isTrue() ? true : $this->publishComment($id);

        $commentId = Uuid::generate();
        $author = kirby()->user();
        $avatar = $author->avatar() ?? 'https://www.gravatar.com/avatar/' .  md5($author->email());

        $newComment = $this->storage->createComment(
            id: $commentId,
            pageUuid: $formData['pageUuid'],
            parentId: $id,
            type: 'comment',
            content: $formData['content'],
            authorName: $author->username(),
            authorAvatar: $avatar,
            authorEmail: $author->email(),
            authorUrl: site()->url(),
            published: $publishResult,
            verified: true,
            spamlevel: 0,
            language: $formData['language'],
            upvotes: 0,
            downvotes: 0,
            createdAt: date('Y-m-d H:i:s', time()),
            updatedAt: date('Y-m-d H:i:s', time()),
        );

        $saveResult = $this->storage->saveComment($newComment);

        return [
            'created' => $saveResult,
            'published' => $publishResult
        ];
    }

    public function getPendingComments(?bool $published = false, ?string $type = null): mixed
    {
        $comments = $this->storage->getCommentsOfSite();
        $filteredComments = $comments->filterBy('published', $published)->sortBy('updatedAt','desc');

        if($type) {
            $filteredComments = $filteredComments->filterBy('type', $type);
        }

        $pages = [];
        $knownUuids = [];
        foreach ($filteredComments as $comment) {
            $uuid = $comment->pageuuid()->value();

            if(in_array($uuid, $knownUuids)) {
                continue;
            }

            $page = page($uuid);
            $knownUuids[] = $uuid;

            $pages[] = [
                'uuid' => $uuid,
                'title' => $page->title()->value() ?? 'Deleted Page',
                'panel' => $page->panel()->url() ?? '#'
            ];
        }

        return [
            'comments' => $filteredComments->toJson(),
            'affectedPages' => $pages
        ];
    }

    public function getAllPageComments(string $pageUuid = null): mixed
    {
        $comments = $this->storage->getCommentsOfPage($pageUuid);
        $filteredComments = $comments->sortBy('updatedAt','desc');

        $pages = [];
        $knownUuids = [];
        foreach ($filteredComments as $comment) {
            $uuid = $comment->pageuuid()->value();

            if(in_array($uuid, $knownUuids)) {
                continue;
            }

            $page = page($uuid);
            $knownUuids[] = $uuid;

            $pages[] = [
                'uuid' => $uuid,
                'title' => $page->title()->value() ?? 'Deleted Page',
                'panel' => $page->panel()->url() ?? '#'
            ];
        }

        $pages = array_unique($pages, SORT_REGULAR);

        return [
            'comments' => $filteredComments->toJson(),
            'affectedPages' => $pages
        ];
    }
}
