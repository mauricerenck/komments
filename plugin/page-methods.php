<?php

namespace mauricerenck\Komments;

return [
    'kommentCount' => function ($language = null) {
        $baseUtils = new KommentBaseUtils();
        return $baseUtils->getCommentsCountOfPage($this, 'published');
    },
    'kommentsAreEnabled' => function () {
        $kommentsFrontend = new KommentsFrontend();

        if ($kommentsFrontend->kommentsAreExpired($this)) {
            return false;
        }

        return $this->kommentsEnabledOnpage()->isEmpty() || $this->kommentsEnabledOnpage()->isTrue();
    },
    'mastodonStatusUrl' => function () {
        if(class_exists('mauricerenck\IndieConnector\MastodonSender')) {
            return $this->icGetMastodonUrl();
        }

        return null;
    },
    'comments' => function () {
        $kommentsFrontend = new KommentsFrontend();
        return $kommentsFrontend->getCommentList($this);
    },
];
