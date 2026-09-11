<?php

use mauricerenck\Komments\WebmentionReceiver;
use mauricerenck\Komments\TestCaseMocked;
use Kirby\Cms\Page;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;

final class WebmentionReceiverTest extends TestCaseMocked
{
    public function setUp(): void
    {
        parent::setUp();
    }


    #[Group('webmentions')]
    #[TestDox('saveWebmention - Process webmention hook data')]
    public function testWebmentionHookData()
    {
        $page = $this->createMock(Page::class);

        // Partiellen Mock deiner eigenen Klasse bauen
        $receiverClass = $this->getMockBuilder(WebmentionReceiver::class)
            ->onlyMethods(['getPageUuid', 'storeWebmention'])
            ->getMock();


        // getPageUuid() immer denselben String zurückgeben lassen,
        // unabhängig vom übergebenen Argument
        $receiverClass->method('getPageUuid')->willReturn('page://my-fake-uuid');


        $webmention = json_decode(file_get_contents(__DIR__ . '/fixtures/webmentionhook.json'), true);

        $result = $receiverClass->saveWebmention($webmention, $page);
        $this->assertSame('in-reply-to', $result->get('type')->value());
        $this->assertSame('This is my reply', $result->get('content')->value());
        $this->assertSame('User', $result->get('authorName')->value());
        $this->assertSame(null, $result->get('authorEmail')->value());
        $this->assertSame('https://example.com/avatar.jpg', $result->get('authorAvatar')->value());
        $this->assertSame('https://example.com/indieconnector/response/gx93jja7iplkv9ac', $result->get('authorUrl')->value());
        $this->assertSame('PUBLISHED', $result->get('verification_status')->value());
        $this->assertSame(true, $result->get('published')->value());
        $this->assertSame(false, $result->get('verified')->value());
        $this->assertSame(null, $result->get('language')->value());
        $this->assertSame('2026-09-10 17:00:38', $result->get('createdAt')->value());
    }
}
