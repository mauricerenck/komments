<?php

namespace mauricerenck\Komments;

use Kirby\Toolkit\Str;

class KommentNotifications
{
    public function sendNotifications(): void
    {
        $moderation = new KommentModeration();
        $pendingModerations = $moderation->getPendingComments();
        $pendingComments = json_decode($pendingModerations['comments']);

        $count = count($pendingComments);

        $spamLimit = option('mauricerenck.komments.spam.sensibility', 60);
        $noneSpamComments = array_filter($pendingComments, function ($comment) use ($spamLimit) {
            return $comment->spamlevel < $spamLimit;
        });

        $spamComments = array_filter($pendingComments, function ($comment) use ($spamLimit) {
            return $comment->spamlevel >= $spamLimit;
        });

        $spamCount = count($spamComments);

        if ($spamCount === $count && option('mauricerenck.komments.notifications.skipSpam', true)) {
            return;
        }

        $mailSummary = '';
        foreach ($noneSpamComments as $comment) {
            $email = !empty($comment->authoremail) ? ' (' . $comment->authoremail . ')' : '';
            $mailSummary .= '- ' . $comment->authorname . $email . ': ' . Str::excerpt($comment->content, 100) . "\n";
        }

        $spamSummary = '';
        foreach ($spamComments as $comment) {
            $email = !empty($comment->authoremail) ? ' (' . $comment->authoremail . ')' : '';
            $spamSummary .= '- ' . $comment->authorname . $email . ': ' . Str::excerpt($comment->content, 100) . "\n";
        }

        $this->sendEmailNotification($count, $spamCount, $mailSummary, $spamSummary);
    }

    public function sendEmailNotification(int $count, int $spamCount, string $mailSummary, string $spamSummary): void
    {
        if (!option('mauricerenck.komments.notifications.email.enable', false)) {
            return;
        }

        $receipients = option('mauricerenck.komments.notifications.email.emailReceiverList', []);
        $panelUrl = kirby()->url('panel');

        if ($count > 0) {
            kirby()->email([
                'from' => option('mauricerenck.komments.notifications.email.sender'),
                'to' => $receipients,
                'subject' => 'New comments received',
                'template' => 'newcomments',
                'data' => [
                    'pendingComments' => $count,
                    'spamComments' => $spamCount,
                    'panelUrl' => $panelUrl,
                    'mailSummary' => $mailSummary,
                    'spamSummary' => $spamSummary,
                ],
            ]);
        }
    }
}
