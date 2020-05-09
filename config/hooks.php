<?php

namespace Plugin\Komments;

use Kirby\Http\Server;
use Kirby\Data\yaml;

return[
    'page.update:after' => function ($newPage, $oldPage) {
        $webmentionSender = new WebmentionSender($newPage);

        if (option('mauricerenck.komments.send-mention-on-update', true) && !$newPage->isDraft() && $webmentionSender->templateIsWhitelisted($newPage->template())) {
            $sendWebmention = new WebmentionSender($newPage);
            $sendWebmention->send();
        }
    },
    'page.changeStatus:after' => function ($newPage, $oldPage) {
        if (option('mauricerenck.komments.send-to-mastodon-on-publish', false)) {
            if ($newPage->isListed() && !$oldPage->isListed() && $webmentionSender->templateIsWhitelisted($newPage->template())) {
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
            file_put_contents('webmentionhook.' . $time . '.json', json_encode($response));
        }

        $kommentReceiver = new KommentReceiver();
        $newEntry = $kommentReceiver->createKomment($webmention);
        $kommentReceiver->storeData($newEntry, $targetPage);
    }
];
