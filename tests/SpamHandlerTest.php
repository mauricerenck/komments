<?php

use mauricerenck\Komments\TestCaseMocked;
use mauricerenck\Komments\SpamHandler;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;

final class SpamHandlerTest extends TestCaseMocked
{
    public function setUp(): void
    {
        parent::setUp();
    }

    #[Group('spam')]
    #[TestDox('getSpamlevel - all good → lvl 0')]
    public function testGetSpamlevelZero()
    {
        $spamHandler = new SpamHandler();

        $fields = [
            'url' => '',
            'comment' => 'hello world'
        ];

        $result = $spamHandler->getSpamlevel($fields, "page://phpunit");
        $this->assertEquals(0, $result);
    }

    #[Group('spam')]
    #[TestDox('getSpamlevel - url in text → lvl 12')]
    public function testGetSpamlevel12()
    {
        $spamHandler = new SpamHandler();

        $fields = [
            'url' => '',
            'comment' => 'hello world https://example.com'
        ];

        $result = $spamHandler->getSpamlevel($fields, 'page://phpunit');
        $this->assertEquals(12, $result);
    }

    #[Group('spam')]
    #[TestDox('getSpamlevel - 2 url in text → lvl 14')]
    public function testGetSpamlevel14()
    {
        $spamHandler = new SpamHandler();

        $fields = [
            'url' => '',
            'comment' => 'hello world https://example.com https://example-2.com'
        ];

        $result = $spamHandler->getSpamlevel($fields, 'page://phpunit');
        $this->assertEquals(14, $result);
    }

    #[Group('spam')]
    #[TestDox('getSpamlevel - html in text → lvl 60')]
    public function testGetSpamlevel60()
    {
        $spamHandler = new SpamHandler();

        $fields = [
            'url' => '',
            'comment' => 'hello <strong>world</strong>'
        ];

        $result = $spamHandler->getSpamlevel($fields, 'page://phpunit');
        $this->assertEquals(80, $result);
    }

    #[Group('spam')]
    #[TestDox('getSpamlevel - honeypot filled → lvl 80')]
    public function testGetSpamlevel80()
    {
        $spamHandler = new SpamHandler();

        $fields = [
            'url' => 'hi',
            'comment' => 'hello world'
        ];

        $result = $spamHandler->getSpamlevel($fields, 'page://phpunit');
        $this->assertEquals(80, $result);
    }

    #[Group('spam')]
    #[TestDox('getSpamlevel - honeypot filled with url → lvl 100')]
    public function testGetSpamlevel100()
    {
        $spamHandler = new SpamHandler();

        $fields = [
            'url' => 'https://example.com',
            'comment' => 'hello world'
        ];

        $result = $spamHandler->getSpamlevel($fields, 'page://phpunit');
        $this->assertEquals(100, $result);
    }

    #[Group('spam')]
    #[TestDox('getSpamlevel - honeypot filled with url, html in text → lvl 100')]
    public function testGetSpamlevelMax100()
    {
        $spamHandler = new SpamHandler();

        $fields = [
            'url' => 'https://example.com',
            'comment' => 'hello <strong>world</strong>'
        ];

        $result = $spamHandler->getSpamlevel($fields, 'page://phpunit');
        $this->assertEquals(100, $result);
    }
}
