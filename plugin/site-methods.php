<?php

namespace mauricerenck\Komments;

return [
    'numberOfPendingComments' => function () {
        $storage = StorageFactory::create();
        $comments = $storage->getCommentsOfSite();

        $filter = option('mauricerenck.komments.spam.verification.filterUnverified', true) ? 'VERIFIED' : 'PENDING';
        $unpublishedComments = $comments->filterBy('verification_status', $filter);

        if (!option('mauricerenck.komments.panel.webmentions', false)) {
            $unpublishedComments = $unpublishedComments->filterBy('type', 'comment');
        }

        return $unpublishedComments->count();
    },
    'numberOfSpamComments' => function () {
        $storage = StorageFactory::create();
        $comments = $storage->getCommentsOfSite();
        $spamComments = $comments->filter(
            fn($child) => $child->spamlevel()->value() >= option('mauricerenck.komments.spam.sensibility', 60)
        );

        return $spamComments->count();
    },
    'latestComments' => function ($limit = 5, $showWebmentions = false) {
        $storage = StorageFactory::create();
        $comments = $storage->getCommentsOfSite();

        $publishedComments = $comments->filterBy('verification_status', 'PUBLISHED')
            ->sortBy('createdAt', 'desc');

        if (!$showWebmentions) {
            $publishedComments = $publishedComments->filterBy('type', 'comment');
        }

        return $publishedComments->limit($limit);;
    },
    'latestCommentsPerPage' => function ($limit = 5, $showWebmentions = false) {
        $storage = StorageFactory::create();
        $comments = $storage->getCommentsOfSite();

        $publishedComments = $comments->filterBy('verification_status', 'PUBLISHED');

        if (!$showWebmentions) {
            $publishedComments = $publishedComments->filterBy('type', 'comment');
        }

        $publishedComments = $publishedComments
            ->sortBy('createdAt', 'desc')
            ->groupBy('pageUuid');

        return $publishedComments->limit($limit);
    },
];
