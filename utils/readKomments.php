<?php
namespace Plugin\Komments;

class ReadKomments {

    public function __construct() {
        return true;
    }

    public function showKommentList($page) {
        $komments = $this->getKommentsByPage($page);
        return $komments;
    }

    public function getKommentsByPage($page) {
        $komments = $page->find('komments');
        return ($komments !== null) ? $komments->children()->filterBy('replyTo', $page->id())->published()->sortBy('date', 'asc') : null;
    }

    public function getKommentsByKomment($page, $slug) {
        $komment = page($slug);
        $komments = $page->find('komments');

        if($komments === null) { return null; }

        $replies = $komments->children()->filterBy('replyTo', $komment->id())->published()->sortBy('date', 'asc');;
        return ($replies !== null) ? $replies : null;
    }
}