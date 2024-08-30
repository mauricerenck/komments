<?php

namespace mauricerenck\Komments;

use Kirby\Uuid\Uuid;
use Kirby\Content\Content;

class WebmentionReceiver {

    public function saveWebmention(array $webmention, $page): Content {
        $storage = StorageFactory::create();
        $id = Uuid::generate();

        $autoPublish = option('mauricerenck.komments.webmentions.publish', true);
        $spamlevel = 0;

        $comment = $storage->createComment(
            id: $id,
            pageUuid: $page->uuid(),
            parentId: '',
            type: $webmention['type'],
            content: $webmention['content'],
            authorName: $webmention['author']['name'],
            authorAvatar: $webmention['author']['avatar'],
            authorEmail: null,
            authorUrl: $webmention['source'],
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
