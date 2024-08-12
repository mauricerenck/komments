<?php

namespace mauricerenck\Komments;

return [
    'kommentCount' => function ($language = null) {
        $baseUtils = new KommentBaseUtils();
        return $baseUtils->getCommentsCountOfPage($this, 'published');
    },
    'hasQueuedKomments' => function ($kommentId, $kommenStatus) {
        deprecated('`hasQueuedKomments()` is deprecated, queued comment cookies habe been removed, this is no more needed. `hasQueuedKomments()` will be removed in future versions.');
        return 0;
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
