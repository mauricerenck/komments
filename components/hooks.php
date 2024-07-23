<?php

namespace mauricerenck\Komments;

return [
    'tratschtante.webhook.received' => function ($webmention, $targetPage) {
        if (!option('mauricerenck.komments.enable-webmention-support')) {
            return;
        }

        if (!option('mauricerenck.komments.debug')) {
            $time = time();
            file_put_contents('webmentionhook.' . $time . '.json', json_encode($webmention));
        }

        $kommentReceiver = new KommentReceiver();
        $newEntry = $kommentReceiver->createKomment($webmention);
        $kommentReceiver->storeData($newEntry, $targetPage);
    },
    'indieConnector.webmention.received' => function ($webmention, $targetPage) {
        if (!option('mauricerenck.komments.debug', false)) {
            $time = time();
            file_put_contents('webmentionhook.' . $time . '.json', json_encode($webmention));
        }

        $kommentReceiver = new KommentReceiver();
        $newEntry = $kommentReceiver->createKomment($webmention);
        $kommentReceiver->storeData($newEntry, $targetPage);
    },
    'komments.comment.received' => function () {
        if (option('mauricerenck.komments.notifications.email.notificationMode', 'instant') === 'instant') {
            $notifications = new KommentNotificationUtils();
            $notifications->sendNotifications();
        }
    }
];
