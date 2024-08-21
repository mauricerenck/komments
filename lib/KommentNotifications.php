<?php

namespace mauricerenck\Komments;

class KommentNotifications
{
    private $pendingComments;

    public function sendNotifications(): void
    {
        $storage = StorageFactory::create();
        $allComments = $storage->getCommentsOfSite();
        $count = $allComments->filter('published', '==', false)->count();

        $this->sendEmailNotification($count);
    }

    public function sendEmailNotification(int $count): void
    {
        if (!option('mauricerenck.komments.notifications.email.enable', false)) {
            return;
        }

        $receipients = option('mauricerenck.komments.notifications.email.emailReceiverList', []);
        $panelUrl = site()->url() . '/panel/komments';

        if ($count > 0) {
            kirby()->email([
                'from' => option('mauricerenck.komments.notifications.email.sender'),
                'to' => $receipients,
                'subject' => 'New Comments received',
                'template' => 'newcomments',
                'data' => [
                    'pendingComments' => $count,
                    'panelUrl' => $panelUrl,
                ],
            ]);
        }
    }
}
