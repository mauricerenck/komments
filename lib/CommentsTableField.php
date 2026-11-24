<?php

namespace mauricerenck\Komments;

use Kirby\Form\Field\ValueField;
use Kirby\Reflection\Attributes\Prop;

class CommentsTableField extends ValueField
{
    #[Prop]
    protected array|null $columns = null;

    #[Prop]
    protected bool $webmentions = true;

    protected mixed $value = null;

    public function props(): array
    {
        return [
            ...parent::props(),
            'comments' => $this->comments(),
            'affectedPages' => $this->affectedPages(),
        ];
    }

    public function comments(): mixed
    {
        $kommentModeration = new KommentModeration();
        // TODO this is a woraround: https://github.com/getkirby/kirby/issues/4955
        $uuid = (string) $this->model()->content()->get('uuid');
        $comments = $kommentModeration->getAllPageComments(pageUuid: 'page://' . $uuid);

        // ORIGINAL returns the uuid as page://UUID
        // $comments = $kommentModeration->getAllPageComments(pageUuid: $this->model()->uuid());

        return json_decode($comments['comments']);
    }

    public function affectedPages(): array
    {
        $kommentModeration = new KommentModeration();
        // TODO this is a woraround: https://github.com/getkirby/kirby/issues/4955
        $uuid = (string) $this->model()->content()->get('uuid');
        $comments = $kommentModeration->getAllPageComments(pageUuid: 'page://' . $uuid);

        // ORIGINAL returns the uuid as page://UUID
        // $comments = $kommentModeration->getAllPageComments(pageUuid: $this->model()->uuid());
        return $comments['affectedPages'];
    }

    public function columns(): array
    {
        $defaultColumns = ['author', 'content', 'spamlevel', 'verified', 'published', 'type'];
        return $this->columns ?? $defaultColumns;
    }
}
