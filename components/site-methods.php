<?php

namespace mauricerenck\Komments;

use mauricerenck\Komments\KommentBaseUtils;

return [
    'numberOfPendingComments' => function () {
        $kommentBaseUtils = new KommentBaseUtils();
        return $kommentBaseUtils->getSiteWideCommentCount('pending');
    },
    'numberOfSpamComments' => function () {
        $kommentBaseUtils = new KommentBaseUtils();
        return $kommentBaseUtils->getSiteWideCommentCount('spam');
    },
];
