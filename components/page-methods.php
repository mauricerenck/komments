<?php

namespace mauricerenck\Komments;

use mauricerenck\Komments\KommentBaseUtils;
use mauricerenck\Komments\KommentModeration;

return [
    'kommentCount' => function () {
        $count = 0;
        foreach ($this->kommentsInbox()->yaml() as $komment) {
            if ($komment['status'] !== 'false' && $komment['status'] !== false) {
                $count++;
            }
        }
        return $count;
    },
    'hasQueuedKomments' => function ($kommentId, $kommenStatus) {
        $kommentModeration = new KommentModeration();
        return $kommentModeration->pageHasQueuedKomments($kommentId, $kommenStatus);
    },
    'kommentsAreEnabled' => function () {
        $kommentBaseUtils = new KommentBaseUtils();

        if ($kommentBaseUtils->kommentsAreExpired($this)) {
            return false;
        }

        return $this->kommentsEnabledOnpage()->isEmpty() || $this->kommentsEnabledOnpage()->isTrue();
    },
];
