<?php

namespace mauricerenck\Komments;

use mauricerenck\Komments\KommentBaseUtils;

return [
    'numberOfPendingComments' => function () {
        $kommentBaseUtils = new KommentBaseUtils();
        return $kommentBaseUtils->getPendingCommentCount();
    },
    'numberOfSpamComments' => function () {
        $kommentBaseUtils = new KommentBaseUtils();
        return $kommentBaseUtils->getSpamCommentCount();
    }
];
