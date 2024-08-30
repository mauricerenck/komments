<?php

namespace mauricerenck\Komments;

return [
    'indieConnector.webmention.received' => function ($webmention, $targetPage) {
        if (option('mauricerenck.komments.debug', false)) {
            $time = time();
            file_put_contents('webmentionhook.' . $time . '.json', json_encode($webmention));
        }

        $page = page($targetPage);

        if (is_null($page)) {
            return;
        }

        $webmentionReceiver = new WebmentionReceiver();
        $webmentionReceiver->saveWebmention($webmention, $page);
    },
    'komments.comment.received' => function () {
        if (option('mauricerenck.komments.notifications.email.notificationMode', 'instant') === 'instant') {
            $notifications = new KommentNotifications();
            $notifications->sendNotifications();
        }
    },
    'system.loadPlugins:after' => function () {
        $migrations = new Migrations();
        $migrations->migrate();
    },
];
