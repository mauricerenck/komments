<?php

namespace mauricerenck\Komments;

return [
    'commentCount' => function ($language = null): int {
        $storage = StorageFactory::create();
        $comments = $storage->getCommentsOfPage($this->uuid());
        $publishedComments = $comments->filterBy('published', true);

        if (!is_null($language)) {
            $publishedComments = $publishedComments->filterBy('language', $language);
        }

        return $publishedComments->count();
    },
    'commentsAreEnabled' => function () {
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
