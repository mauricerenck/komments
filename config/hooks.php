<?php

namespace mauricerenck\Komments;

use Kirby\Http\Server;
use Kirby\Data\yaml;

return [
    'page.update:after' => function ($newPage, $oldPage) {
        $webmentionSender = new WebmentionSender($newPage);
        if (option('mauricerenck.komments.send-mention-on-update', true) && !$newPage->isDraft() && $webmentionSender->templateIsWhitelisted($newPage->intendedTemplate())) {
            $sendWebmention = new WebmentionSender($newPage);
            $sendWebmention->send();
        }
    },
    'page.changeStatus:after' => function ($newPage, $oldPage) {
        if (option('mauricerenck.komments.send-to-mastodon-on-publish', false)) {
            $webmentionSender = new WebmentionSender($newPage);

            if ($newPage->isListed() && !$oldPage->isListed() && $webmentionSender->templateIsWhitelisted($newPage->intendedTemplate())) {
                $mastodon = new MastodonSender();
                $mastodon->sendToot($newPage);
            }
        }
    },
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
    'komments.comment.received' => function () {
        if (option('mauricerenck.komments.notifications.email.notificationMode', 'instant') === 'instant') {
            $notifications = new KommentNotificationUtils();
            $notifications->sendNotifications();
        }
    }
];
