<?php

namespace Plugin\Komments;

use Kirby\Toolkit\Str;

class MastodonSender
{
    public function sendToot($page)
    {
        $tootMaxLength = 280;
        $postUrl = $page->url();
        $urlLength = Str::length($postUrl);
        $trimTextPosition = $tootMaxLength - $urlLength - 2;
        $textfield = option('mauricerenck.komments.mastodon-text-field', 'mastodonTeaser');
        $message = ($page->$textfield()->isNotEmpty()) ? $page->$textfield() : Str::short($page->title(), $trimTextPosition);
        $message .= ' ' . $postUrl;

        $headers = [
            'Authorization: Bearer ' . option('mauricerenck.komments.mastodon-bearer')
        ];

        $status_data = [
            'status' => $message,
            'language' => 'de',
            'visibility' => 'public'
        ];

        $ch_status = curl_init();
        curl_setopt($ch_status, CURLOPT_URL, option('mauricerenck.komments.mastodon-instance-url'));
        curl_setopt($ch_status, CURLOPT_POST, 1);
        curl_setopt($ch_status, CURLOPT_POSTFIELDS, $status_data);
        curl_setopt($ch_status, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_status, CURLOPT_HTTPHEADER, $headers);

        $output_status = json_decode(curl_exec($ch_status));

        curl_close($ch_status);
    }
}
