<?php

namespace mauricerenck\Komments;

use Kirby\Cms\Structure;
use Kirby\Content\Content;
use Kirby\Toolkit\Obj;
use Kirby\Toolkit\Collection;

class Storage
{

    public function __construct() {}

    public function getSingleComment(string $commentId): Content {}

    public function getCommentsOfPage(string $pageUuid): Structure {}

    public function getCommentsOfSite(): Structure {}

    public function saveComment(Content $comment): bool {}

    public function updateComment(string $commentId, array $values): bool {}

    public function deleteComment(string $commentId): bool {}

    /**
     * @param array<Obj|Collection> $databaseResults
     * @return Collection
     */
    public function convertToStructure(Obj|Collection|Structure $databaseResults): Structure {}

    public function saveVerificationToken(string $hash, string $commentId, string $expiresAt): bool {}
}
