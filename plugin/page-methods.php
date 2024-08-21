<?php

namespace mauricerenck\Komments;

return [
    'kommentCount' => function ($language = null): int {
        $storage = StorageFactory::create();
        $comments = $storage->getCommentsOfPage($this->uuid());
        $publishedComments = $comments->filterBy('published', true);

        if (!is_null($language)) {
            $publishedComments = $publishedComments->filterBy('language', $language);
        }

        return $publishedComments->count();

    },
    'kommentsAreEnabled' => function () {
        $kommentsFrontend = new KommentsFrontend();

        if ($kommentsFrontend->kommentsAreExpired($this)) {
            return false;
        }

        return $this->kommentsEnabledOnpage()->isEmpty() || $this->kommentsEnabledOnpage()->isTrue();
    },
    'comments' => function () {
        $kommentsFrontend = new KommentsFrontend();
        return $kommentsFrontend->getCommentList($this);
    },
];
