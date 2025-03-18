<?php

namespace mauricerenck\Komments;

use Kirby\Cms\Structure;

class KommentsFrontend
{
    private $storage;

    public function __construct(private ?int $expireAfterNumOfDays = null, private ?string $dateField = null)
    {
        $this->storage = StorageFactory::create();

        $this->expireAfterNumOfDays = $expireAfterNumOfDays ?? option('mauricerenck.komments.autoDisable.ttl', 0);
        $this->dateField = $dateField ?? option('mauricerenck.komments.autoDisable.datefield', 'date');
    }

    public function kommentsAreExpired($page)
    {
        if ($this->expireAfterNumOfDays === 0) {
            return false;
        }

        $dateFieldName = $this->dateField;

        if (is_null($page->$dateFieldName()) || $page->$dateFieldName()->exists() === false) {
            return false;
        }

        $publishDate = $page->$dateFieldName()->toDate();

        if ($publishDate === 0) {
            return false;
        }

        $now = time();

        if ($now - $publishDate > $this->expireAfterNumOfDays * 24 * 60 * 60) {
            return true;
        }

        return false;
    }

    public function getCommentList($page): Structure
    {
        $comments = $this->storage->getCommentsOfPage($page->uuid());
        $publishedComments = $comments->filterBy('published', true);

        return $publishedComments;
    }
}
