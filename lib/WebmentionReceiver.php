<?php

namespace mauricerenck\Komments;

use Kirby\Uuid\Uuid;

class WebmentionReceiver
{
    public function saveWebmention(array $webmention, $page)
    {
        if (!option('mauricerenck.komments.webmentions.enabled', true)) {
            return null;
        }

        $storage = StorageFactory::create();
        $id = Uuid::generate();

        $autoPublish = option('mauricerenck.komments.webmentions.publish', true);
        $spamlevel = 0;

        $webmentionHost = parse_url($webmention['source'], PHP_URL_HOST);

        if ($comments = $storage->getCommentsOfPage($page->uuid()->toString())) {
            $comment = $comments->filterBy('authorUrl', $webmention['source'])->filterBy('type', $webmention['type']);

            if ($comment->count() > 0) {
                return $comment->first();
            }
        }

        $comment = $storage->createComment(
            id: $id,
            pageUuid: $page->uuid(),
            parentId: '',
            type: $webmention['type'],
            content: $webmention['content'],
            authorName: $webmention['author']['name'] ?? $webmentionHost,
            authorAvatar: $webmention['author']['avatar'] ?? '',
            authorEmail: null,
            authorUrl: $webmention['source'],
            status: $autoPublish ? 'PUBISHED' : 'PENDING',
            published: $autoPublish,
            verified: false,
            spamlevel: $spamlevel,
            language: null,
            upvotes: 0,
            downvotes: 0,
            createdAt: $webmention['published'],
            updatedAt: $webmention['published'],
        );

        $storage->saveComment($comment);

        return $comment;
    }
}
