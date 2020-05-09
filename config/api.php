<?php

namespace Plugin\Komments;

use Xml;
use File;
use Structure;

return [
    'routes' => [
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
                            if ($komment['status'] == 'false' && (integer)$komment['spamlevel'] == 0) {
                                $pendingKomments[] = [
                                    'author' => $komment['author'],
                                    'komment' => $komment['komment'],
                                    'kommentType' => $komment['kommenttype'],
                                    'image' => $komment['avatar'],
                                    'title' => (string) $item->title(),
                                    'url' => $item->panelUrl(),
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
                                    'kommentType' => $komment['kommenttype'],
                                    'image' => $komment['avatar'],
                                    'title' => (string) $item->title(),
                                    'url' => $item->panelUrl(),
                                ];
                            }
                        }
                    }
                }

                return json_encode($spamKomments);
            }
        ],
    ]
];
