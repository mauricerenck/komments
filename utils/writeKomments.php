<?php
namespace Plugin\Komments;
use kirby;
use Page;
use Str;

class WriteKomments {

    public function __construct() {
        return true;
    }

    public function createKomment($slug, $komment) {

        $kirby = kirby();
        $kirby->impersonate(option('mauricerenck.komments.kommentUserId'));

        $page = page($slug . '/komments');

        if($page === null) {
            $this->createKomments($slug);
            $page = page($slug . '/komments');
        }

        $newPage = $page->createChild([
            'slug'     => Str::random(),
            'template' => 'komment',
            'content' => [
                'title' => $komment->title,
                'author'  => $komment->author,
                'email' => $komment->email,
                'text' => $komment->text,
                'replyTo' => $komment->replyTo,
                'date' => date('c'),
            ]
          ]);
    }

    private function createKomments($slug) {
        $kirby = kirby();
        $kirby->impersonate(option('mauricerenck.komments.kommentUserId'));

        $page = page($slug);

        $newPage = $page->createChild([
            'slug'     => 'komments',
            'template' => 'komments',
            'content' => [
              'title'  => 'Komments',
            ]
          ]);

          $newPage->changeStatus('unlisted');
    }
}