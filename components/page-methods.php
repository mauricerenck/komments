<?php

namespace mauricerenck\Komments;

use mauricerenck\Komments\KommentBaseUtils;

return [
    'kommentCount' => function () {
        $count = 0;
        // FIXME Multilanuage support
        foreach ($this->kommentsInbox()->yaml() as $komment) {
            if ($komment['status'] !== 'false' && $komment['status'] !== false) {
                $count++;
            }
        }
        return $count;
    },
    'hasQueuedKomments' => function ($kommentId, $kommenStatus) {
        deprecated('`hasQueuedKomments()` is deprecated, queued comment cookies habe been removed, this is no more needed. `hasQueuedKomments()` will be removed in future versions.');
        return 0;
    },
    'kommentsAreEnabled' => function () {
        $kommentBaseUtils = new KommentBaseUtils();

        if ($kommentBaseUtils->kommentsAreExpired($this)) {
            return false;
        }

        return $this->kommentsEnabledOnpage()->isEmpty() || $this->kommentsEnabledOnpage()->isTrue();
    },
];
