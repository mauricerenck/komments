<?php

namespace mauricerenck\Komments;

class KommentNotificationUtils
{
    private $pendingComments;

    public function sendNotifications()
    {
        $kommentUtils = new KommentBaseUtils();
        $this->pendingComments = $kommentUtils->getSiteWideComments('pending');

        $this->sendEmailNotification();
    }

    public function sendEmailNotification()
    {
        if (!option('mauricerenck.komments.notifications.email.enable', false)) {
            return;
        }

        $receipients = option('mauricerenck.komments.notifications.email.emailReceiverList', []);
        $panelUrl = site()->url() . '/panel/komments';

        $pendingCommentsCount = count($this->pendingComments);

        if ($pendingCommentsCount > 0) {
            kirby()->email([
                'from' => option('mauricerenck.komments.notifications.email.sender'),
                'to' => $receipients,
                'subject' => 'New Comments received',
                'template' => 'newcomments',
                'data' => [
                    'pendingComments' => $pendingCommentsCount,
                    'panelUrl' => $panelUrl,
                ],
            ]);
        }
    }
}
