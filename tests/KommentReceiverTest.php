<?php

use mauricerenck\Komments\KommentReceiver;
use mauricerenck\Komments\TestCaseMocked;
use mauricerenck\Komments\CommentVerification;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;

final class KommentReceiverTest extends TestCaseMocked
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /* ********************************
    ** validation author url
    ********************************** */

    #[Group('validation')]
    #[TestDox('validateFields - AuthorUrl not set')]
    public function testValidateFieldsAuthorUrlNotSet()
    {
        $receiverClass = new KommentReceiver();

        $fields = [
            'email' => 'user@example.com',
            'author' => 'Example Author',
            'comment' => 'lorem ipsum dolor sit amet.'
        ];

        $result = $receiverClass->validateFields($fields);
        $this->assertEquals([], $result);
    }

    #[Group('validation')]
    #[TestDox('validateFields - AuthorUrl empty')]
    public function testValidateFieldsAuthorUrlEmpty()
    {
        $receiverClass = new KommentReceiver();

        $fields = [
            'author_url' => '',
            'email' => 'user@example.com',
            'author' => 'Example Author',
            'comment' => 'lorem ipsum dolor sit amet.'
        ];

        $result = $receiverClass->validateFields($fields);
        $this->assertEquals([], $result);
    }

    #[Group('validation')]
    #[TestDox('validateFields - AuthorUrl set')]
    public function testValidateFieldsAuthorUrlSet()
    {
        $receiverClass = new KommentReceiver();

        $fields = [
            'author_url' => 'https://www.example.com',
            'email' => 'user@example.com',
            'author' => 'Example Author',
            'comment' => 'lorem ipsum dolor sit amet.'
        ];

        $result = $receiverClass->validateFields($fields);
        $this->assertEquals([], $result);
    }

    #[Group('validation')]
    #[TestDox('validateFields - AuthorUrl invalid')]
    public function testValidateFieldsAuthorUrlInvalid()
    {
        $receiverClass = new KommentReceiver();

        $fields = [
            'author_url' => 'no-valid-url',
            'email' => 'user@example.com',
            'author' => 'Example Author',
            'comment' => 'lorem ipsum dolor sit amet.'
        ];

        $result = $receiverClass->validateFields($fields);
        $this->assertEquals(['author_url'], $result);
    }

    /* ********************************
    ** validation email
    ********************************** */

    #[Group('validation')]
    #[TestDox('validateFields - email required and set')]
    public function testValidateFieldsEmailRequiredSet()
    {
        $receiverClass = new KommentReceiver();

        $fields = [
            'email' => 'user@example.com',
            'author' => 'Example Author',
            'comment' => 'lorem ipsum dolor sit amet.'
        ];

        $result = $receiverClass->validateFields($fields);
        $this->assertEquals([], $result);
    }

    #[Group('validation')]
    #[TestDox('validateFields - email required and not set')]
    public function testValidateFieldsEmailRequiredNotSet()
    {
        $receiverClass = new KommentReceiver();

        $fields = [
            'email' => '',
            'author' => 'Example Author',
            'comment' => 'lorem ipsum dolor sit amet.'
        ];

        $result = $receiverClass->validateFields($fields);
        $this->assertEquals(['email'], $result);
    }

    #[Group('validation')]
    #[TestDox('validateFields - email required and invalid')]
    public function testValidateFieldsEmailRequiredInvalid()
    {
        $receiverClass = new KommentReceiver();

        $fields = [
            'email' => 'no-valid-email',
            'author' => 'Example Author',
            'comment' => 'lorem ipsum dolor sit amet.'
        ];

        $result = $receiverClass->validateFields($fields);
        $this->assertEquals(['email'], $result);
    }

    /* ********************************
    ** validation comment
    ********************************** */

    #[Group('validation')]
    #[TestDox('validateFields - comment required and set')]
    public function testValidateFieldsCommentRequiredSet()
    {
        $receiverClass = new KommentReceiver();

        $fields = [
            'email' => 'user@example.com',
            'author' => 'Example Author',
            'comment' => 'lorem ipsum dolor sit amet.'
        ];

        $result = $receiverClass->validateFields($fields);
        $this->assertEquals([], $result);
    }

    #[Group('validation')]
    #[TestDox('validateFields - comment required and not set')]
    public function testValidateFieldsCommentRequiredNotSet()
    {
        $receiverClass = new KommentReceiver();

        $fields = [
            'email' => 'user@example.com',
            'author' => 'Example Author',
            'comment' => ''
        ];

        $result = $receiverClass->validateFields($fields);
        $this->assertEquals(['comment'], $result);
    }

    #[Group('validation')]
    #[TestDox('validateFields - comment required and whitespace only')]
    public function testValidateFieldsCommentRequiredTooShort()
    {
        $receiverClass = new KommentReceiver();

        $fields = [
            'email' => 'user@example.com',
            'author' => 'Example Author',
            'comment' => ' '
        ];

        $result = $receiverClass->validateFields($fields);
        $this->assertEquals(['comment'], $result);
    }

    /* ********************************
    ** validation author
    ********************************** */

    #[Group('validation')]
    #[TestDox('validateFields - author required and set')]
    public function testValidateFieldsAuthorRequiredSet()
    {
        $receiverClass = new KommentReceiver();

        $fields = [
            'email' => 'user@example.com',
            'author' => 'Example Author',
            'comment' => 'lorem ipsum dolor sit amet.'
        ];

        $result = $receiverClass->validateFields($fields);
        $this->assertEquals([], $result);
    }

    #[Group('validation')]
    #[TestDox('validateFields - author required and not set')]
    public function testValidateFieldsAuthorRequiredNotSet()
    {
        $receiverClass = new KommentReceiver();

        $fields = [
            'email' => 'user@example.com',
            'author' => '',
            'comment' => 'lorem ipsum dolor sit amet.'
        ];

        $result = $receiverClass->validateFields($fields);
        $this->assertEquals(['author'], $result);
    }

    #[Group('validation')]
    #[TestDox('validateFields - author required and set')]
    public function testValidateFieldsAuthorNotRequiredSet()
    {
        $receiverClass = new KommentReceiver(requireAuthor: false);

        $fields = [
            'email' => 'user@example.com',
            'author' => 'Example Author',
            'comment' => 'lorem ipsum dolor sit amet.'
        ];

        $result = $receiverClass->validateFields($fields);
        $this->assertEquals([], $result);
    }

    #[Group('validation')]
    #[TestDox('validateFields - author required and not set')]
    public function testValidateFieldsAuthorNotRequiredNotSet()
    {
        $receiverClass = new KommentReceiver(requireAuthor: false);

        $fields = [
            'email' => 'user@example.com',
            'author' => '',
            'comment' => 'lorem ipsum dolor sit amet.'
        ];

        $result = $receiverClass->validateFields($fields);
        $this->assertEquals([], $result);
    }


    /* ********************************
    ** isEmailRequired
    ********************************** */

    #[Group('validation')]
    #[TestDox('isEmailRequired - required option true')]
    public function testIsEmailRequiredTrue()
    {
        $receiver = new KommentReceiver(
            requireEmail: true,
            storeEmail: false,
        );

        $this->assertTrue($receiver->isEmailRequired());
    }

    #[Group('validation')]
    #[TestDox('isEmailRequired - store option true')]
    public function testIsEmailRequiredFalse()
    {

        $receiver = new KommentReceiver(
            requireEmail: false,
            storeEmail: true,
        );

        $this->assertTrue($receiver->isEmailRequired());
    }

    #[Group('validation')]
    #[TestDox('isEmailRequired - verification option true')]
    public function testReturnsTrueWhenVerificationIsEnabled(): void
    {
        $verificationMock = $this->createMock(CommentVerification::class);
        $verificationMock->method('isVerificationEnabled')->willReturn(true);

        $receiver = new KommentReceiver(
            requireEmail: false,
            storeEmail: false,
            commentVerification: $verificationMock,
        );

        $this->assertTrue($receiver->isEmailRequired());
    }

    #[Group('validation')]
    #[TestDox('isEmailRequired - no mail required')]
    public function testReturnsFalseWhenNothingRequiresEmail(): void
    {
        $verificationMock = $this->createMock(CommentVerification::class);
        $verificationMock->method('isVerificationEnabled')->willReturn(false);

        $receiver = new KommentReceiver(
            requireEmail: false,
            storeEmail: false,
            commentVerification: $verificationMock,
        );

        $this->assertFalse($receiver->isEmailRequired());
    }


    /* ********************************
    ** validation general
    ********************************** */

    #[Group('validation')]
    #[TestDox('validateFields - all set')]
    public function testValidateFieldsAllSet()
    {
        $receiverClass = new KommentReceiver();

        $fields = [
            'email' => 'user@example.com',
            'author_url' => 'https://example.com',
            'author' => 'Example Author',
            'comment' => 'lorem ipsum dolor sit amet.'
        ];

        $result = $receiverClass->validateFields($fields);
        $this->assertEquals([], $result);
    }

    #[Group('validation')]
    #[TestDox('validateFields - some missing or invalid')]
    public function testValidateFieldsMissingInvalid()
    {
        $receiverClass = new KommentReceiver();

        $fields = [
            'email' => '',
            'author_url' => 'example.com',
            'author' => 'Example Author',
            'comment' => 'lorem ipsum dolor sit amet.'
        ];

        $result = $receiverClass->validateFields($fields);
        $this->assertEquals(['author_url', 'email'], $result);
    }
    /**
     * @group spam
     * @testdox getSpamlevel - should return level 0
     */
    public function testGetSpamlevelZero()
    {
        $receiverClass = new KommentReceiver();
        $page = $this->getPageMock();

        $fields = [
            'url' => '',
            'comment' => 'hello world'
        ];

        $result = $receiverClass->getSpamlevel($fields, $page);
        $this->assertEquals(0, $result);
    }

    /**
     * @group spam
     * @testdox getSpamlevel - should return level 12
     */
    public function testGetSpamlevel12()
    {
        $receiverClass = new KommentReceiver();
        $page = $this->getPageMock();

        $fields = [
            'url' => '',
            'comment' => 'hello world https://example.com'
        ];

        $result = $receiverClass->getSpamlevel($fields, $page);
        $this->assertEquals(12, $result);
    }

    /**
     * @group spam
     * @testdox getSpamlevel - should return level 14
     */
    public function testGetSpamlevel14()
    {
        $receiverClass = new KommentReceiver();
        $page = $this->getPageMock();

        $fields = [
            'url' => '',
            'comment' => 'hello world https://example.com https://example-2.com'
        ];

        $result = $receiverClass->getSpamlevel($fields, $page);
        $this->assertEquals(14, $result);
    }

    /**
     * @group spam
     * @testdox getSpamlevel - should return level 60
     */
    public function testGetSpamlevel60()
    {
        $receiverClass = new KommentReceiver();
        $page = $this->getPageMock();

        $fields = [
            'url' => '',
            'comment' => 'hello <strong>world</strong>'
        ];

        $result = $receiverClass->getSpamlevel($fields, $page);
        $this->assertEquals(80, $result);
    }

    /**
     * @group spam
     * @testdox getSpamlevel - should return level 80
     */
    public function testGetSpamlevel80()
    {
        $receiverClass = new KommentReceiver();
        $page = $this->getPageMock();

        $fields = [
            'url' => 'hi',
            'comment' => 'hello world'
        ];

        $result = $receiverClass->getSpamlevel($fields, $page);
        $this->assertEquals(80, $result);
    }

    /**
     * @group spam
     * @testdox getSpamlevel - should return level 100
     */
    public function testGetSpamlevel100()
    {
        $receiverClass = new KommentReceiver();
        $page = $this->getPageMock();

        $fields = [
            'url' => 'https://example.com',
            'comment' => 'hello world'
        ];

        $result = $receiverClass->getSpamlevel($fields, $page);
        $this->assertEquals(100, $result);
    }

    /**
     * @group spam
     * @testdox getSpamlevel - should return level 100
     */
    public function testGetSpamlevelMax100()
    {
        $receiverClass = new KommentReceiver();
        $page = $this->getPageMock();

        $fields = [
            'url' => 'https://example.com',
            'comment' => 'hello <strong>world</strong>'
        ];

        $result = $receiverClass->getSpamlevel($fields, $page);
        $this->assertEquals(100, $result);
    }

    /**
     * @group moderation
     * @testdox autoPublish - should auto publish by email
     */
    public function testAutoPublish()
    {
        $receiverClass = new KommentReceiver(autoPublish: ['user@example.com']);

        $result = $receiverClass->autoPublish('user@example.com', false);
        $this->assertTrue($result);
    }

    /**
     * @group moderation
     * @testdox autoPublish - should auto publish by verification
     */
    public function testAutoPublishVerified()
    {
        $receiverClass = new KommentReceiver(autoPublishVerified: true);

        $result = $receiverClass->autoPublish('user@example.com', true);
        $this->assertTrue($result);
    }

    /**
     * @group moderation
     * @testdox autoPublish - should not auto publish
     */
    public function testAutoPublishShouldNot()
    {
        $receiverClass = new KommentReceiver();

        $result = $receiverClass->autoPublish('user@example.com', false);
        $this->assertFalse($result);
    }

    /**
     * @group moderation
     * @testdox getAvatarFromEmail - should return url string
     */
    public function testGetAvatarFromEmail()
    {
        $receiverClass = new KommentReceiver();
        $mailHash = md5('user@example.com');

        $result = $receiverClass->getAvatarFromEmail('user@example.com');
        $this->assertEquals('https://www.gravatar.com/avatar/' . $mailHash, $result);
    }

    /**
     * @group moderation
     * @testdox createSafeString - should return safe string
     */
    public function testCreateSafeString()
    {
        $receiverClass = new KommentReceiver();

        $result = $receiverClass->createSafeString('<strong>hello</strong>');
        $this->assertEquals('hello', $result);
    }

    /**
     * @group verification
     * @testdox generateToken - returns token on success
     */
    // public function testGenerateTokenReturnsTokenOnSuccess()
    // {
    //     $receiver = new KommentReceiver(
    //         verificationTtl: 1,
    //         verificationSecret: 'secret'
    //     );

    //     $token = $receiver->generateToken('test@example.com', 'comment123');
    //     $this->assertIsString($token);
    //     $parts = explode('.', $token);
    //     $this->assertCount(2, $parts);
    //     $this->assertNotEmpty($parts[0]); // hash
    //     $this->assertNotEmpty($parts[1]); // base64 timestamp
    //     $this->assertEquals(base64_decode($parts[1]), time() + 1 * 60 * 60, '', 2); // allow small time drift
    // }

    /**
     * @group verification
     * @testdox generateToken - returns false on failure
     */
    // public function testGenerateTokenReturnsFalseOnStorageFailure()
    // {
    //     $storageMock = $this->createMock(StorageClass::class);
    //     $storageMock->method('saveVerificationToken')->willReturn(false);
    //     StorageFactory::$mock = $storageMock;

    //     $receiver = new KommentReceiver(
    //         verificationTtl: 1,
    //         verificationSecret: 'secret'
    //     );

    //     $token = $receiver->generateToken('test@example.com', 'comment123');
    //     $this->assertFalse($token);
    // }
}
