<?php

namespace mauricerenck\Komments;

use Structure;
use Kirby\Http\Response;

return [
    'routes' => [
        [
            'pattern' => 'komments/queued',
            'action' => function () {

                $pendingKomments = [];
                $collection = site()->index();

                foreach ($collection as $item) {
                    if ($item->kommentsInbox()->isNotEmpty()) {
                        foreach ($item->kommentsInbox()->yaml() as $komment) {
                            $komment['spamlevel'] = (isset($komment['spamlevel'])) ? $komment['spamlevel'] : 0; // backward compatiblity

                            if (($komment['status'] === 'false' || $komment['status'] === false) && (integer)$komment['spamlevel'] === 0) {
                                $pendingKomments[] = [
                                    'author' => $komment['author'],
                                    'komment' => $komment['komment'],
                                    'kommentType' => (isset($komment['kommenttype'])) ? $komment['kommenttype'] : 'komment', // backward compatiblity
                                    'image' => $komment['avatar'],
                                    'title' => (string) $item->title(),
                                    'url' => $item->panel()->url(),
                                ];
                            }
                        }
                    }
                }

                return new Response(json_encode($pendingKomments), 'application/json');
            }
        ],
        [
            'pattern' => 'komments/spam',
            'action' => function () {
                $spamKomments = [];
                $collection = site()->index();


                foreach ($collection as $item) {
                    if ($item->kommentsInbox()->isNotEmpty()) {
                        foreach ($item->kommentsInbox()->yaml() as $komment) {
                            $komment['spamlevel'] = (isset($komment['spamlevel'])) ? $komment['spamlevel'] : 0; // backward compatiblity
                            if ((integer)$komment['spamlevel'] > 0) {
                                $spamKomments[] = [
                                    'author' => $komment['author'],
                                    'komment' => $komment['komment'],
                                    'kommentType' => (isset($komment['kommenttype'])) ? $komment['kommenttype'] : 'komment', // backward compatiblity
                                    'image' => $komment['avatar'],
                                    'title' => (string) $item->title(),
                                    'url' => $item->panel()->url(),
                                ];
                            }
                        }
                    }
                }

                return new Response(json_encode($spamKomments), 'application/json');
            }
        ],
        [
            'pattern' => 'komments/spam',
            'method' => 'POST',
            'action' => function () {
                $formData = kirby()->request()->data();

                $kommentModeration = new KommentModeration();
                $kommentModeration->markAsSpam($formData['pageSlug'], $formData['kommentId'], $formData['isSpam']);

                return new Response(json_encode(['message' => 'okay']), 'application/json');
            }
        ],
        [
            'pattern' => 'komments/verify',
            'method' => 'POST',
            'action' => function () {
                $formData = kirby()->request()->data();

                $kommentModeration = new KommentModeration();
                $kommentModeration->markAsVerified($formData['pageSlug'], $formData['kommentId'], $formData['isVerified']);

                return new Response(json_encode(['message' => 'okay']), 'application/json');
            }
        ],
        [
            'pattern' => 'komments/publish',
            'method' => 'POST',
            'action' => function () {
                $formData = kirby()->request()->data();

                $kommentModeration = new KommentModeration();
                $kommentModeration->publish($formData['pageSlug'], $formData['kommentId'], $formData['isPublished']);

                return new Response(json_encode(['message' => 'okay']), 'application/json');
            }
        ],
        [
            'pattern' => 'komments/delete',
            'method' => 'POST',
            'action' => function () {
                $formData = kirby()->request()->data();

                $kommentModeration = new KommentModeration();
                $kommentModeration->delete($formData['pageSlug'], $formData['kommentId']);

                return new Response(json_encode(['message' => 'okay']), 'application/json');
            }
        ],
    ]
];
