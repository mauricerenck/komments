<?php

namespace mauricerenck\Komments;

use Exception;
use Kirby\Data\yaml;

class KommentModeration
{

    public function markAsSpam($pageSlug, $kommentId, $isSpam)
    {
        try {
            $baseUtils = new KommentBaseUtils();
            $targetPage = $baseUtils->getPageFromSlug($pageSlug);

            if (!$targetPage) {
                throw new Exception('Page not found', 1);
            }

            $fieldData = $targetPage->kommentsInbox()->yaml();

            for ($i = 0; $i < count($fieldData); $i++) {
                if (isset($fieldData[$i]['id'])) { // backward compatibility
                    if ($fieldData[$i]['id'] === $kommentId) {
                        if ($isSpam) {
                            $fieldData[$i]['status'] = false;
                            $fieldData[$i]['verified'] = false;
                            $fieldData[$i]['spamlevel'] = 100;
                        } else {
                            $fieldData[$i]['spamlevel'] = 0;
                        }
                    }
                }
            }

            $fieldData = yaml::encode($fieldData);

            $kirby = kirby();
            $kirby->impersonate('kirby');
            $targetPage->update([
                'kommentsInbox' => $fieldData
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function markAsVerified($pageSlug, $kommentId, $isVerified)
    {
        try {
            $baseUtils = new KommentBaseUtils();
            $targetPage = $baseUtils->getPageFromSlug($pageSlug);

            if (!$targetPage) {
                throw new Exception('Page not found', 1);
            }

            $fieldData = $targetPage->kommentsInbox()->yaml();

            for ($i = 0; $i < count($fieldData); $i++) {
                if (isset($fieldData[$i]['id'])) { // backward compatibility
                    if ($fieldData[$i]['id'] === $kommentId) {
                        $fieldData[$i]['verified'] = $isVerified;
                    }
                }
            }

            $fieldData = yaml::encode($fieldData);

            $kirby = kirby();
            $kirby->impersonate('kirby');
            $targetPage->update([
                'kommentsInbox' => $fieldData
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function publish($pageSlug, $kommentId, $publish)
    {
        try {
            $baseUtils = new KommentBaseUtils();
            $targetPage = $baseUtils->getPageFromSlug($pageSlug);

            if (!$targetPage) {
                throw new Exception('Page not found', 1);
            }

            $fieldData = $targetPage->kommentsInbox()->yaml();

            for ($i = 0; $i < count($fieldData); $i++) {
                if (isset($fieldData[$i]['id'])) { // backward compatibility
                    if ($fieldData[$i]['id'] === $kommentId) {
                        $fieldData[$i]['status'] = $publish;
                    }
                }
            }

            $fieldData = yaml::encode($fieldData);

            $kirby = kirby();
            $kirby->impersonate('kirby');
            $targetPage->update([
                'kommentsInbox' => $fieldData
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($pageSlug, $kommentId)
    {
        try {
            $baseUtils = new KommentBaseUtils();
            $targetPage = $baseUtils->getPageFromSlug($pageSlug);

            if (!$targetPage) {
                throw new Exception('Page not found', 1);
            }

            $fieldData = $targetPage->kommentsInbox()->yaml();
            $newFieldData = [];

            for ($i = 0; $i < count($fieldData); $i++) {
                if (isset($fieldData[$i]['id'])) { // backward compatibility
                    if ($fieldData[$i]['id'] !== $kommentId) {
                        $newFieldData[] = $fieldData[$i];
                    }
                }
            }

            $newFieldData = yaml::encode($newFieldData);

            $kirby = kirby();
            $kirby->impersonate('kirby');
            $targetPage->update([
                'kommentsInbox' => $newFieldData
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
