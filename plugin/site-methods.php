<?php

namespace mauricerenck\Komments;

return [
    'numberOfPendingComments' => function () {
        $storage = StorageFactory::create();
        $comments = $storage->getCommentsOfSite();
        $unpublishedComments = $comments->filterBy('published', false);

        return $unpublishedComments->count();
    },
    'numberOfSpamComments' => function () {
        $storage = StorageFactory::create();
        $comments = $storage->getCommentsOfSite();
        $spamComments = $comments->filter(
            fn ($child) => $child->spamlevel()->value() >= option('mauricerenck.komments.spam.sensibility', 60)
        );

        return $spamComments->count();
    },
];
