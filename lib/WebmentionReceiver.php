<?php

namespace mauricerenck\Komments;

use Kirby\Cms\Page;
use Kirby\Uuid\Uuid;

class WebmentionReceiver
{
    public function getPageUuid($page)
    {
        return $page instanceof Page ? $page->uuid()->toString() : $page;
    }

    public function storeWebmention($comment)
    {
        $storage = StorageFactory::create();
        $storage->saveComment($comment);
    }

    public function saveWebmention(array $webmention, $page)
    {
        if (!option('mauricerenck.komments.webmentions.enabled', true)) {
            return null;
        }

        $storage = StorageFactory::create();
        $id = Uuid::generate();
        $pageUuid = $this->getPageUuid($page);

        $autoPublish = option('mauricerenck.komments.webmentions.publish', true);

        $webmentionHost = parse_url($webmention['source'], PHP_URL_HOST);

        if ($comments = $storage->getCommentsOfPage($pageUuid)) {
            $comment = $comments->filterBy('authorUrl', $webmention['source'])->filterBy('type', $webmention['type']);

            if ($comment->count() > 0) {
                return $comment->first();
            }
        }

        $utils = new KommentUtils();
        $comment = $utils->createStructuredComment(
            id: $id,
            type: $webmention['type'],
            pageUuid: $pageUuid,
            parentId: '',
            comment: $webmention['content'],
            authorName: $webmention['author']['name'] ?? $webmentionHost,
            authorAvatar: $webmention['author']['avatar'] ?? '',
            authorEmail: null,
            authorUrl: $webmention['source'],
            verificationStatus: $autoPublish ? 'PUBLISHED' : 'VERIFIED',
            published: $autoPublish,
            verified: false,
            spamLevel: 0,
            language: null,
            upvotes: 0,
            downvotes: 0,
            createdAt: $webmention['published'],
            updatedAt: $webmention['published']
        );

        $this->storeWebmention($comment);
        kirby()->trigger('komments.comment.received', ['comment' => $comment]);

        if ($autoPublish) {
            kirby()->trigger('komments.comment.published', ['comment' => $comment]);
        }

        return $comment;
    }
}
