<?php

use mauricerenck\Komments\TestCaseMocked;
use mauricerenck\Komments\KommentUtils;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;

final class KommentUtilsTest extends TestCaseMocked
{
    public function setUp(): void
    {
        parent::setUp();
    }


    #[Group('utils')]
    #[TestDox('createSafeString - should return safe string')]
    public function testCreateSafeString()
    {
        $utilsClass = new KommentUtils();

        $result = $utilsClass->createSafeString('<strong>hello</strong>');
        $this->assertEquals('hello', $result);
    }

    #[Group('utils')]
    #[TestDox('createStructuredComment - should return content')]
    public function testCreateStructuredComment()
    {
        $utilsClass = new KommentUtils();

        $expectedArray = [
            'id' => '1',
            'pageuuid' => 'page://phpunit',
            'parentid' => '1234',
            'content' => 'This is my comment',
            'authorname' => 'Jonny',
            'authoravatar' => 'abc',
            'authoremail' => 'user@example.com',
            'authorurl' => 'https://example.com',
            'verification_status' => 'PENDING',
            'published' => false,
            'verified' => false,
            'spamlevel' => 0,
            'language' => '',
            'upvotes' => 0,
            'downvotes' => 0,
            'createdat' => 'now',
            'updatedat' => 'now',
            'permalink' => '/@/comment/1',
            'type' => 'comment'
        ];

        $result = $utilsClass->createStructuredComment(
            id: '1',
            pageUuid: 'page://phpunit',
            parentId: '1234',
            comment: 'This is my comment',
            authorName: 'Jonny',
            authorAvatar: 'abc',
            authorEmail: 'user@example.com',
            authorUrl: 'https://example.com',
            verificationStatus: 'PENDING',
            published: false,
            verified: false,
            spamLevel: 0,
            language: '',
            upvotes: 0,
            downvotes: 0,
            createdAt: 'now',
            updatedAt: 'now',
        );
        $this->assertEqualsCanonicalizing($expectedArray, $result->toArray());
    }
}
