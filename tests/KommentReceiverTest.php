<?php

use mauricerenck\Komments\KommentReceiver;
use mauricerenck\Komments\TestCaseMocked;

final class KommentReceiverTest extends TestCaseMocked
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @group validation
     * @testdox validateFields - should return no invalid fields
     */
    public function testValidateFields()
    {
        $receiverClass = new KommentReceiver();

        $fields = [
            'author_url' => 'https://www.example.com',
            'email' => 'user@example.com',
            'author' => 'Author Name',
            'comment' => 'lorem ipsum dolor sit amet.'
        ];

        $result = $receiverClass->validateFields($fields);
        $this->assertEquals([], $result);
    }

    /**
     * @group validation
     * @testdox validateFields - should return invalid author url
     */
    public function testValidateFieldsAuthorUrl()
    {
        $receiverClass = new KommentReceiver();

        $fields = [
            'author_url' => 'no-url',
            'email' => 'user@example.com',
            'author' => 'Author Name',
            'comment' => 'lorem ipsum dolor sit amet.'
        ];

        $result = $receiverClass->validateFields($fields);
        $this->assertEquals(['author_url'], $result);
    }

    /**
     * @group validation
     * @testdox validateFields - should not return invalid author url
     */
    public function testValidateFieldsAuthorUrlEmpty()
    {
        $receiverClass = new KommentReceiver();

        $fields = [
            'author_url' => '',
            'email' => 'user@example.com',
            'author' => 'Author Name',
            'comment' => 'lorem ipsum dolor sit amet.'
        ];

        $result = $receiverClass->validateFields($fields);
        $this->assertEquals([], $result);
    }


    /**
    * @group validation
    * @testdox validateFields - should return invalid email
    */
    public function testValidateFieldsEmail()
    {
        $receiverClass = new KommentReceiver();

        $fields = [
            'author_url' => 'https://www.example.com',
            'email' => 'user_example.com',
            'author' => 'Author Name',
            'comment' => 'lorem ipsum dolor sit amet.'
        ];

        $result = $receiverClass->validateFields($fields);
        $this->assertEquals(['email'], $result);
    }

    /**
    * @group validation
    * @testdox validateFields - should return invalid author
    */
    public function testValidateFieldsAuthor()
    {
        $receiverClass = new KommentReceiver();

        $fields = [
            'author_url' => 'https://www.example.com',
            'email' => 'user@example.com',
            'author' => '',
            'comment' => 'lorem ipsum dolor sit amet.'
        ];

        $result = $receiverClass->validateFields($fields);
        $this->assertEquals(['author'], $result);
    }

    /**
    * @group validation
    * @testdox validateFields - should return invalid author
    */
    public function testValidateFieldsComment()
    {
        $receiverClass = new KommentReceiver();

        $fields = [
            'author_url' => 'https://www.example.com',
            'email' => 'user@example.com',
            'author' => 'Author Name',
            'comment' => ''
        ];

        $result = $receiverClass->validateFields($fields);
        $this->assertEquals(['comment'], $result);
    }

    /**
    * @group validation
    * @testdox validateFields - should return invalid fields
    */
    public function testValidateFieldsMultiple()
    {
        $receiverClass = new KommentReceiver();

        $fields = [
            'author_url' => 'https://www.example.com',
            'email' => 'user_example.com',
            'author' => 'Author Name',
            'comment' => ''
        ];

        $result = $receiverClass->validateFields($fields);
        $this->assertEquals(['email','comment'], $result);
    }

    /**
    * @group spam
    * @testdox getSpamlevel - should return level 0
    */
    public function testGetSpamlevelZero()
    {
        $receiverClass = new KommentReceiver();

        $fields = [
            'url' => '',
            'comment' => 'hello world'
        ];

        $result = $receiverClass->getSpamlevel($fields);
        $this->assertEquals(0, $result);
    }

    /**
    * @group spam
    * @testdox getSpamlevel - should return level 12
    */
    public function testGetSpamlevel12()
    {
        $receiverClass = new KommentReceiver();

        $fields = [
            'url' => '',
            'comment' => 'hello world https://example.com'
        ];

        $result = $receiverClass->getSpamlevel($fields);
        $this->assertEquals(12, $result);
    }

    /**
    * @group spam
    * @testdox getSpamlevel - should return level 14
    */
    public function testGetSpamlevel14()
    {
        $receiverClass = new KommentReceiver();

        $fields = [
            'url' => '',
            'comment' => 'hello world https://example.com https://example-2.com'
        ];

        $result = $receiverClass->getSpamlevel($fields);
        $this->assertEquals(14, $result);
    }

    /**
    * @group spam
    * @testdox getSpamlevel - should return level 60
    */
    public function testGetSpamlevel60()
    {
        $receiverClass = new KommentReceiver();

        $fields = [
            'url' => '',
            'comment' => 'hello <strong>world</strong>'
        ];

        $result = $receiverClass->getSpamlevel($fields);
        $this->assertEquals(60, $result);
    }

    /**
    * @group spam
    * @testdox getSpamlevel - should return level 80
    */
    public function testGetSpamlevel80()
    {
        $receiverClass = new KommentReceiver();

        $fields = [
            'url' => 'hi',
            'comment' => 'hello world'
        ];

        $result = $receiverClass->getSpamlevel($fields);
        $this->assertEquals(80, $result);
    }

    /**
    * @group spam
    * @testdox getSpamlevel - should return level 100
    */
    public function testGetSpamlevel100()
    {
        $receiverClass = new KommentReceiver();

        $fields = [
            'url' => 'https://example.com',
            'comment' => 'hello world'
        ];

        $result = $receiverClass->getSpamlevel($fields);
        $this->assertEquals(100, $result);
    }

    /**
    * @group spam
    * @testdox getSpamlevel - should return level 100
    */
    public function testGetSpamlevelMax100()
    {
        $receiverClass = new KommentReceiver();

        $fields = [
            'url' => 'https://example.com',
            'comment' => 'hello <strong>world</strong>'
        ];

        $result = $receiverClass->getSpamlevel($fields);
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
}
