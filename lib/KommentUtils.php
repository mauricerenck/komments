<?php

namespace mauricerenck\Komments;

use Kirby\Content\Content;
use Kirby\Toolkit\Str;

class KommentUtils
{

    public function createSafeString(string $fieldValue): string
    {
        return $this->sanitizeString(Str::unhtml($fieldValue));
    }

    public function sanitizeString(string $comment): string
    {
        // Remove non-printable characters
        $comment = preg_replace('/[^\P{C}\n]+/u', '', $comment);
        // Convert special characters to HTML entities
        $comment = htmlspecialchars($comment, ENT_QUOTES, 'UTF-8');
        // Trim whitespace
        $comment = trim($comment);
        return $comment;
    }

    public function createStructuredComment(
        string $id,
        string $pageUuid,
        string $parentId,
        string $comment,
        string | null $authorName,
        string | null $authorAvatar,
        string | null $authorEmail,
        string | null $authorUrl,
        string $verificationStatus,
        bool $published,
        bool $verified,
        int $spamLevel,
        string $language,
        int $upvotes,
        int $downvotes,
        string $createdAt,
        string $updatedAt,
        ?string $type = 'comment',
    ): Content {
        return new Content([
            'id' => $id,
            'pageUuid' => $pageUuid,
            'parentId' => $parentId,
            'type' => $type,

            'content' => $comment,

            'authorName' => $authorName,
            'authorAvatar' => $authorAvatar,
            'authorEmail' => $authorEmail,
            'authorUrl' => $authorUrl,

            'verification_status' => $verificationStatus,
            'published' => $published,
            'verified' => $verified,
            'spamlevel' => $spamLevel,
            'language' => $language,
            'upvotes' => $upvotes,
            'downvotes' => $downvotes,
            'createdAt' => $createdAt,
            'updatedAt' => $updatedAt,
            'permalink' => '/@/comment/' . $id,
        ]);
    }
}
