<?php

namespace mauricerenck\Komments;

use Xml;
use File;
use f;
use Structure;

return [
    'routes' => [
        [
            'pattern' => 'komments/version',
            'action' => function () {
                $string = f::read(__DIR__ . '/../composer.json');
                return $string;
            }
        ],
        [
            'pattern' => 'komments/queued',
            'action' => function () {
                $pendingKomments = [];
                $collection = site()->index();
                $komments = new Structure();
                $key = 0;

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

                return json_encode($pendingKomments);
            }
        ],
        [
            'pattern' => 'komments/spam',
            'action' => function () {
                $spamKomments = [];
                $collection = site()->index();
                $komments = new Structure();
                $key = 0;

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

                return json_encode($spamKomments);
            }
        ],
        [
            'pattern' => 'komments/spam',
            'method' => 'POST',
            'action' => function () {
                $formData = kirby()->request()->data();

                $kommentModeration = new KommentModeration();
                $kommentModeration->markAsSpam($formData['pageSlug'], $formData['kommentId'], $formData['isSpam']);

                return json_encode(['message' => 'okay']);
            }
        ],
        [
            'pattern' => 'komments/verify',
            'method' => 'POST',
            'action' => function () {
                $formData = kirby()->request()->data();

                $kommentModeration = new KommentModeration();
                $kommentModeration->markAsVerified($formData['pageSlug'], $formData['kommentId'], $formData['isVerified']);

                return json_encode(['message' => 'okay']);
            }
        ],
        [
            'pattern' => 'komments/publish',
            'method' => 'POST',
            'action' => function () {
                $formData = kirby()->request()->data();

                $kommentModeration = new KommentModeration();
                $kommentModeration->publish($formData['pageSlug'], $formData['kommentId'], $formData['isPublished']);

                return json_encode(['message' => 'okay']);
            }
        ],
        [
            'pattern' => 'komments/delete',
            'method' => 'POST',
            'action' => function () {
                $formData = kirby()->request()->data();

                $kommentModeration = new KommentModeration();
                $kommentModeration->delete($formData['pageSlug'], $formData['kommentId']);

                return json_encode(['message' => 'okay']);
            }
        ],
    ]
];
