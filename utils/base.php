<?php

namespace Plugin\Komments;

use json_encode;
use json_decode;
use in_array;

class KommentBaseUtils
{
    // public function __construct()
    // {
    // }

    public function kommentsAreExpired($page)
    {
        $expireAfterNumOfDays = option('mauricerenck.komments.auto-disable-komments', 0);

        if ($expireAfterNumOfDays === 0) {
            return false;
        }

        $dateField = option('mauricerenck.komments.auto-disable-komments-datefield', 'date');
        $publishDate = $page->$dateField()->toDate();
        $now = time();

        if (($now - $publishDate) > $expireAfterNumOfDays * 24 * 60 * 60) {
            return true;
        }

        return false;
    }
}
