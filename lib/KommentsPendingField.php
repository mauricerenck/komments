<?php

namespace mauricerenck\Komments;

use Kirby\Form\Field\ValueField;

class KommentsPendingField extends ValueField
{
    protected mixed $value = null;

    public function props(): array
    {
        return [
            ...parent::props(),
            'queuedComments' => $this->queuedComments(),
        ];
    }

    public function queuedComments(): int
    {
        $storage = StorageFactory::create();
        $comments = $storage->getCommentsOfSite();
        $unpublishedComments = $comments->filterBy('verification_status', 'PUBLISHED');

        return $unpublishedComments->count();
    }
}
