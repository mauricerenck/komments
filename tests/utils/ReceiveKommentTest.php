<?php

use mauricerenck\Komments\KommentReceiver;
use PHPUnit\Framework\TestCase;

final class ReceiveKommentTest extends TestCase
{
    public function testMarkKnownUserAsVerified()
    {
        $kommentReceiver = new KommentReceiver();
        kirby()->impersonate('test@phpunit.de');
        $isVerified = $kommentReceiver->isVerified('test@phpunit.de');
        kirby()->impersonate(null);

        $this->assertTrue($isVerified);
    }

    public function testMarkUnknownUserAsUnverified()
    {
        $kommentReceiver = new KommentReceiver();
        $isVerified = $kommentReceiver->isVerified('unknown@phpunit.de');

        $this->assertFalse($isVerified);
    }

    public function testMarkInvalidEmailAsUnverified()
    {
        $kommentReceiver = new KommentReceiver();
        $isVerified = $kommentReceiver->isVerified('invalid_phpunit.de');

        $this->assertFalse($isVerified);
    }

    public function testAutoPublishKnownAddress()
    {
        $kommentReceiver = new KommentReceiver();
        $isVerified = $kommentReceiver->autoPublish('test@phpunit.de');

        $this->assertTrue($isVerified);
    }
    public function testAutoPublishUnknownAddress()
    {
        $kommentReceiver = new KommentReceiver();
        $isVerified = $kommentReceiver->autoPublish('unknown@phpunit.de');

        $this->assertFalse($isVerified);
    }

    public function testSetEmailAddressDisabled()
    {
        $kommentReceiver = new KommentReceiver();
        $result = $kommentReceiver->setEmail('test@phpunit.de');

        $this->assertNull($result);
    }

    public function testSetConvertToWebmention()
    {
        $commentMock = [
            'komment' => 'This is my comment',
            'url' => '',
            'email' => 'test@phpunit.de',
            'author' => 'John Doe',
            'author_url' => 'https://web.site',
            'wmSource' => 'https://komments.test:8890/en/phpunit',
            'wmTarget' => 'https://komments.test:8890/en/phpunit',
            'wmProperty' => 'komment',
            'quote' => '',
            'replyTo' => '',
            'replyHandle' => '',
            'cts' => 10,
        ];

        $expectedResult = [
            'type' => 'KOMMENT',
            'target' => '/en/phpunit',
            'source' => '/en/phpunit',
            'mentionOf' =>  null,
            'published' => date('c'),
            'content' => 'This is my comment',
            'quote' => '',
            'author' => [
                'type' => 'card',
                'name' => 'John Doe',
                'avatar' => 'https://www.gravatar.com/avatar/cc1bdde8cb8ec60527b5102beafc99a6',
                'url' => 'https://web.site',
                'email' => null,
            ]
        ];

        $kommentReceiver = new KommentReceiver();
        $webmention = $kommentReceiver->convertToWebmention($commentMock, page('phpunit'));

        $this->assertEquals($expectedResult, $webmention);
    }

    public function testGetAuthorData()
    {
        $kommentReceiver = new KommentReceiver();

        $expectedResult = [
            'name' => 'John Doe',
            'avatar' => 'https://web.site/avatar.jpg',
            'url' => 'https://web.site',
            'email' => 'hello@test.tld'
        ];

        $author = $kommentReceiver->getAuthorData([
            'name' => 'John Doe',
            'avatar' => 'https://web.site/avatar.jpg',
            'url' => 'https://web.site',
            'email' => 'hello@test.tld'
        ]);

        $this->assertEquals($expectedResult, $author);
    }

    public function testGetAuthorDataHandlesMissingData()
    {
        $kommentReceiver = new KommentReceiver();

        $expectedResult = [
            'name' => 'John Doe',
            'avatar' => 'https://web.site/avatar.jpg',
            'url' => null,
            'email' => null
        ];

        $author = $kommentReceiver->getAuthorData([
            'name' => 'John Doe',
            'avatar' => 'https://web.site/avatar.jpg',
            'email' => ''
        ]);

        $this->assertEquals($expectedResult, $author);
    }
}
