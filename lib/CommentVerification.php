<?php

namespace mauricerenck\Komments;

use Kirby\Toolkit\Collection;

class CommentVerification
{

    public function __construct(
        private ?bool $verificationEnabled = null,
        private ?int $verificationTtl = null,
        private ?string $verificationSecret = null,
        private ?bool $verificationAutoPublish = null,
        private ?string $verificationDeletionMode = null,
    ) {
        $this->verificationEnabled = $verificationEnabled ?? option('mauricerenck.komments.spam.verification.enabled', false);
        $this->verificationTtl = $verificationTtl ?? option('mauricerenck.komments.spam.verification.ttl', 48);
        $this->verificationSecret = $verificationSecret ?? option('mauricerenck.komments.spam.verification.secret', false);
        $this->verificationAutoPublish = $verificationAutoPublish ?? option('mauricerenck.komments.spam.verification.autoPublish', false);
        $this->verificationDeletionMode = $verificationDeletionMode ?? option('mauricerenck.komments.spam.verification.deletionMode', 'spam');
    }

    public function isVerificationEnabled(): bool
    {
        if (!$this->verificationEnabled || !$this->verificationSecret) {
            return false;
        }

        return true;
    }

    public function generateToken(string $email, string $commentId): string | false
    {
        $expiresAt = time() + $this->verificationTtl * 60 * 60;
        $data = $email . '|' . $commentId . '|' . $expiresAt;
        $hash = hash_hmac('sha256', $data, $this->verificationSecret);

        $storage = StorageFactory::create();

        $result = $storage->saveVerificationToken(
            hash: $hash,
            commentId: $commentId,
            expiresAt: $expiresAt,
        );

        if (!$result) {
            return false;
        }

        // Return token with expiration timestamp encoded
        return $hash . '.' . base64_encode($expiresAt);
    }

    public function getVerificationUrl(string $email, string $commentId): string | false
    {
        $token = $this->generateToken(email: $email, commentId: $commentId);

        if (!$token) {
            return false;
        }

        return kirby()->url() . '/komments/verify-comment/' . $token;
    }

    public function verifyToken(string $token): string | bool
    {
        // Parse token and expiration
        $parts = explode('.', $token);
        if (count($parts) !== 2) {
            return false;
        }

        [$hash, $encodedExpiration] = $parts;
        $expiresAt = base64_decode($encodedExpiration);

        // Check expiration
        if (time() > $expiresAt) {
            return false;
        }

        $storage = StorageFactory::create();
        $tokenData = $storage->getVerificationToken(hash: $hash);

        if (is_null($tokenData) || $tokenData->count() === 0) {
            return false;
        }

        if ($tokenData->first()->expires_at() < time()) {
            return false;
        }

        $updateValues = [];
        $updateValues['status'] = ($this->verificationAutoPublish === true) ? 'PUBLISHED' : 'VERIFIED';

        if ($this->verificationAutoPublish === true) {
            $updateValues['published'] = true;
        }

        $storage->updateComment($tokenData->first()->comment_id(), $updateValues);
        $storage->deleteVerificationToken($hash);
        $storage->cleanupVerificationTokens($this->verificationDeletionMode);

        return $tokenData->first()->comment_id();
    }

    public function cleanupTokens(): void
    {
        $storage = StorageFactory::create();
        $storage->cleanupVerificationTokens($this->verificationDeletionMode);
    }

    public function getVerficationTokens(): Collection
    {
        $storage = StorageFactory::create();
        return $storage->getVerificationTokens();
    }
}
