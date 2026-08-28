<?php

namespace mauricerenck\Komments;

use Kirby\Toolkit\V;
use Kirby\Uuid\Uuid;
use Kirby\Content\Content;

class KommentReceiver
{

    public function __construct(
        private ?array $autoPublish = null,
        private ?bool $autoPublishVerified = null,

        private ?bool $requireAuthor = null,
        private ?bool $requireEmail = null,
        private ?bool $storeEmail = null,

        private ?CommentVerification $commentVerification = null,
        private ?KommentUtils $utils = null,
    ) {
        $this->autoPublish = $autoPublish ?? option('mauricerenck.komments.moderation.autoPublish', []);
        $this->autoPublishVerified = $autoPublishVerified ?? option('mauricerenck.komments.moderation.publish-verified', false);

        $this->requireAuthor = $requireAuthor ?? option('mauricerenck.komments.privacy.requireAuthor', true);
        $this->requireEmail = $requireEmail ?? option('mauricerenck.komments.privacy.requireEmail', true);
        $this->storeEmail = $storeEmail ?? option('mauricerenck.komments.privacy.storeEmail', true);

        $this->commentVerification = $commentVerification ?? new CommentVerification();
        $this->utils = $utils ?? new KommentUtils();
    }

    public function validateFields(array $fields): array
    {
        $inValidFields = [];

        if (isset($fields['author_url']) && V::notEmpty($fields['author_url']) && !V::url($fields['author_url'])) {
            $inValidFields[] = 'author_url';
        }


        if ($this->isEmailRequired()) {
            if (!isset($fields['email']) || !V::email($fields['email'])) {
                $inValidFields[] = 'email';
            }
        }

        if ($this->requireAuthor) {
            if (V::empty($fields['author'])) {
                $inValidFields[] = 'author';
            }
        }

        if (V::empty($fields['comment']) || !V::minWords($fields['comment'], 1)) {
            $inValidFields[] = 'comment';
        }

        return $inValidFields;
    }

    public function transformFormData(array $formData, int $spamLevel, ?bool $forceAutoPublish = false): Content
    {

        $id = Uuid::generate();
        $date = date('c', time());
        $email = (!isset($formData['email']))
            ? null
            : $formData['email'];

        $avatar = $this->getAvatarFromEmail($email);

        if ($this->storeEmail === false) {
            $email = null;
        }

        $verified = $this->isVerified();
        $autoPublish = $forceAutoPublish ?? $this->autoPublish($verified, $email);

        $verificationStatus = $autoPublish
            ? 'PUBLISHED'
            : 'VERIFIED';

        if ($this->commentVerification->isVerificationEnabled()) {
            $verificationStatus = $autoPublish
                ? 'PUBLISHED'
                : 'PENDING';
        }

        if (!isset($formData['author']) || empty($formData['author'])) {
            $formData['author'] = 'Anon' . rand(100, 1000);
        }

        return $this->utils->createStructuredComment(
            id: $id,
            pageUuid: $this->utils->createSafeString($formData['pageUuid']),
            parentId: $this->getParentId($formData['replyTo']),
            comment: $this->utils->createSafeString($formData['comment']),
            authorName: $this->utils->createSafeString($formData['author']),
            authorAvatar: $avatar,
            authorEmail: $email,
            authorUrl: $this->utils->createSafeString($formData['author_url']),
            verificationStatus: $verificationStatus,
            published: $autoPublish,
            verified: $verified,
            spamLevel: $spamLevel,
            language: $this->utils->createSafeString($formData['language']),
            upvotes: 0,
            downvotes: 0,
            createdAt: $date,
            updatedAt: $date
        );
    }


    public function isEmailRequired(): bool
    {
        if ($this->requireEmail === true) {
            return true;
        }

        if ($this->storeEmail === true) {
            return true;
        }

        if ($this->commentVerification->isVerificationEnabled()) {
            return true;
        }

        return false;
    }

    public function isVerified(): bool
    {
        return (!is_null(kirby()->user()) && kirby()->user()->isLoggedIn()) ? true : false;
    }

    public function autoPublish(bool $isVerified, string | null $email = null): bool
    {
        if ($this->autoPublishVerified && $isVerified) {
            return true;
        }

        if (is_null($email)) {
            return false;
        }

        return in_array($email, $this->autoPublish);
    }

    public function getParentId(string $replyTo): string
    {
        return V::notEmpty($replyTo) ? $replyTo : '';
    }

    public function getAvatarFromEmail(string | null $email): ?string
    {
        if (V::email($email)) {
            $mailHash = md5($email);
            return $mailHash;
        }

        return null;
    }

    public function sendVerificationMail(string $email, string $username, string $commentId): void
    {

        $verification = new CommentVerification();
        if (!$verification->isVerificationEnabled()) {
            return;
        }

        $verificationUrl = $verification->getVerificationUrl(email: $email, commentId: $commentId);

        if (!$verificationUrl) {
            return;
        }

        kirby()->email([
            'from' => option('mauricerenck.komments.notifications.email.sender'),
            'to' => $email,
            'subject' => 'Verify your Comment',
            'template' => 'mailverification',
            'data' => [
                'username' => $username,
                'commentId' => $commentId,
                'expireHours' => option('mauricerenck.komments.spam.verification.ttl', 48),
                'verificationUrl' => $verificationUrl,
            ],
        ]);
    }
}
