<?php

namespace mauricerenck\Komments;

use Kirby\Cms\Structure;

class KommentsFrontend
{
    private $storage;

    public function __construct(
        private ?int $expireAfterNumOfDays = null,
        private ?string $dateField = null,
        private ?bool $requireAuthor = null,
        private ?bool $requireEmail = null,
        private ?bool $storeEmail = null,
        private ?bool $verificationEnabled = null,
    ) {
        $this->storage = StorageFactory::create();

        $this->expireAfterNumOfDays = $expireAfterNumOfDays ?? option('mauricerenck.komments.autoDisable.ttl', 0);
        $this->dateField = $dateField ?? option('mauricerenck.komments.autoDisable.datefield', 'date');

        $this->requireAuthor = $requireAuthor ?? option('mauricerenck.komments.privacy.requireAuthor', true);
        $this->requireEmail = $requireEmail ?? option('mauricerenck.komments.privacy.requireEmail', true);
        $this->storeEmail = $storeEmail ?? option('mauricerenck.komments.privacy.storeEmail', true);
        $this->verificationEnabled = $verificationEnabled ?? option('mauricerenck.komments.spam.verification.enabled', false);
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
        $publishedComments = $comments->filterBy('verification_status', 'PUBLISHED');

        return $publishedComments;
    }

    public function requiredFormFields(): array
    {

        $requiredFields = ['comment'];

        if ($this->requireEmail === true) {
            $requiredFields[] = 'email';
        }

        if ($this->storeEmail === true) {
            $requiredFields[] = 'email';
        }

        if ($this->verificationEnabled) {
            $requiredFields[] = 'email';
        }

        if ($this->requireAuthor) {
            $requiredFields[] = 'author';
        }

        return $requiredFields;
    }
}
