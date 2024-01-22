<?php

namespace mauricerenck\Komments;

use mauricerenck\Komments\KommentBaseUtils;
use mauricerenck\Komments\TestCaseMocked;


final class UtilsBaseTest extends TestCaseMocked
{

    public function setUp(): void
    {
        parent::setUp();
    }


    public function testShouldHandleUnkownPage()
    {
        $baseUtils = new KommentBaseUtils();
        $this->assertEquals(false, $baseUtils->getPageFromSlug('fake/page'));
    }

    // TODO how to mock kirby pages?
    // public function testShouldGetPage()
    // {
    //     $pageMock = $this->getMockBuilder(Page::class)
    //         ->enableProxyingToOriginalMethods();

    //     $baseUtils = new KommentBaseUtils();
    //     $this->assertEquals($pageMock, $baseUtils->getPageFromSlug('home'));
    // }

    public function testShouldGetPendingKomments()
    {
        $baseUtils = new KommentBaseUtils();
        $pendingComments = $baseUtils->getPendingKomments();

        $this->assertIsArray($pendingComments);
        $this->assertCount(3, $pendingComments);
    }

    public function testShouldHaveDifferentKommentTypes()
    {
        $baseUtils = new KommentBaseUtils();
        $pendingComments = $baseUtils->getPendingKomments();

        $this->assertFalse($pendingComments[0]['verified']);
        $this->assertFalse($pendingComments[0]['status']);
        $this->assertEquals(0, $pendingComments[0]['spamlevel']);

        $this->assertTrue($pendingComments[1]['verified']);
        $this->assertFalse($pendingComments[1]['status']);
        $this->assertEquals(0, $pendingComments[1]['spamlevel']);

        $this->assertFalse($pendingComments[2]['verified']);
        $this->assertFalse($pendingComments[2]['status']);
        $this->assertEquals(100, $pendingComments[2]['spamlevel']);
    }

    // public function testNeverExpireByDefault()
    // {
    //     $pageMock = $this->getMockBuilder(Page::class)
    //         ->enableProxyingToOriginalMethods();

    //     $baseUtils = new KommentBaseUtils();
    //     $this->assertEquals(0, $baseUtils->kommentsAreExpired($pageMock));
    // }

    // public function testShouldNotBeExpired()
    // {
    //     $pageMock = $this->getMockBuilder(Page::class)
    //         ->enableProxyingToOriginalMethods();

    //     c::set('mauricerenck.komments.auto-disable-komments', 10);
    //     $baseUtils = new KommentBaseUtils();
    //     $this->assertEquals(0, $baseUtils->kommentsAreExpired($pageMock));
    // }

    // public function testReturnCommentCount()
    // {
    //     $pageMock = $this->getMockBuilder(Page::class)
    //         ->enableProxyingToOriginalMethods();

    //     $baseUtils = new KommentBaseUtils();
    //     $this->assertEquals(3, $baseUtils->getPendingCommentCount());
    // }

    // public function testReturnSpamCommentCount()
    // {
    //     $pageMock = $this->getMockBuilder(Page::class)
    //         ->enableProxyingToOriginalMethods();

    //     $baseUtils = new KommentBaseUtils();
    //     $this->assertEquals(1, $baseUtils->getSpamCommentCount());
    // }

    /**
     * @group panel
     * @testdox getCommentsOfPage - should get 3 comments
     */
    public function testGetCommentsOfPage()
    {
        $pageMock = $this->getPageMock();
        $baseUtils = new KommentBaseUtils();

        $expectedResult = [
            [
                'id' => '1bfffa3f189b3c5b5d6f3ed3271d3342',
                'slug' => 'phpunit-test',
                'author' => 'Unknown user',
                'authorUrl' => '',
                'komment' => '<p>A regular comment of an unkown user</p>',
                'kommentType' => 'KOMMENT',
                'image' => 'https://www.gravatar.com/avatar/c67cfe10182e385fcd4181c06334a527',
                'title' => 'phpunit-test',
                'url' => '/panel/pages/phpunit-test',
                'published' => '2021-11-10 13:50',
                'verified' => false,
                'spamlevel' => 0,
                'status' => false
            ],
            [
                'id' => 'c62bc1426c1d39eb6d8a6b4f5b3ef3ee',
                'slug' => 'phpunit-test',
                'author' => 'Verified User',
                'authorUrl' => 'https://maurice-renck.de',
                'komment' => '<p>A regular comment of a verified user</p>',
                'kommentType' => 'KOMMENT',
                'image' => 'https://www.gravatar.com/avatar/8b77c0a84579af62f82da07d9abedf56',
                'title' => 'phpunit-test',
                'url' => '/panel/pages/phpunit-test',
                'published' => '2021-11-10 13:50',
                'verified' => true,
                'spamlevel' => 0,
                'status' => true
            ],
            [
                'id' => '594a3bdc4947c1a8496d2beb8a065cb1',
                'slug' => 'phpunit-test',
                'author' => 'SpamBot',
                'authorUrl' => '',
                'komment' => '<p>A spam comment by an evil bot</p>',
                'kommentType' => 'KOMMENT',
                'image' => 'https://www.gravatar.com/avatar/fa5d3b1755664ea7cb3c8ef1e00a5a52',
                'title' => 'phpunit-test',
                'url' => '/panel/pages/phpunit-test',
                'published' => '2021-11-10 13:50',
                'verified' => false,
                'spamlevel' => 100,
                'status' => false
            ],
        ];

        $result = $baseUtils->getCommentsOfPage($pageMock);
        $this->assertEquals($result, $expectedResult);
    }


    /**
     * @group panel
     * @testdox getCommentsOfPage - should get 2 pending comments, no public
     */
    public function testGetCommentsOfPageNoPublic()
    {
        $pageMock = $this->getPageMock(false, [
            'kommentsInbox' => '
            - 
              author: Unknown user
              avatar: >
                https://www.gravatar.com/avatar/c67cfe10182e385fcd4181c06334a527
              authorurl: ""
              authoremail: ""
              kommenttype: KOMMENT
              quote: ""
              komment: A regular comment of an unkown user
              source: https://komments.test:8890/phpunit
              target: https://komments.test:8890/phpunit
              mentionof: https://komments.test:8890/phpunit
              property: KOMMENT
              published: 2021-11-10 13:50:00
              status: "true"
              verified: "false"
              id: 1bfffa3f189b3c5b5d6f3ed3271d3342
              spamlevel: 0
            - 
              author: Verified User
              avatar: >
                https://www.gravatar.com/avatar/8b77c0a84579af62f82da07d9abedf56
              authorurl: https://maurice-renck.de
              authoremail: ""
              kommenttype: KOMMENT
              quote: ""
              komment: A regular comment of a verified user
              source: https://komments.test:8890/phpunit
              target: https://komments.test:8890/phpunit
              mentionof: https://komments.test:8890/phpunit
              property: KOMMENT
              published: 2021-11-10 13:50:00
              status: "false"
              verified: "true"
              id: c62bc1426c1d39eb6d8a6b4f5b3ef3ee
              spamlevel: 0
            - 
              author: SpamBot
              avatar: >
                https://www.gravatar.com/avatar/fa5d3b1755664ea7cb3c8ef1e00a5a52
              authorurl: ""
              authoremail: ""
              kommenttype: KOMMENT
              quote: ""
              komment: A spam comment by an evil bot
              source: https://komments.test:8890/phpunit
              target: https://komments.test:8890/phpunit
              mentionof: https://komments.test:8890/phpunit
              property: KOMMENT
              published: 2021-11-10 13:50:00
              status: "false"
              verified: "false"
              id: 594a3bdc4947c1a8496d2beb8a065cb1
              spamlevel: 100'
        ]);

        $expectedResult = [
            [
                'id' => 'c62bc1426c1d39eb6d8a6b4f5b3ef3ee',
                'slug' => 'phpunit-test',
                'author' => 'Verified User',
                'authorUrl' => 'https://maurice-renck.de',
                'komment' => '<p>A regular comment of a verified user</p>',
                'kommentType' => 'KOMMENT',
                'image' => 'https://www.gravatar.com/avatar/8b77c0a84579af62f82da07d9abedf56',
                'title' => 'phpunit-test',
                'url' => '/panel/pages/phpunit-test',
                'published' => '2021-11-10 13:50',
                'verified' => true,
                'spamlevel' => 0,
                'status' => false
            ],
            [
                'id' => '594a3bdc4947c1a8496d2beb8a065cb1',
                'slug' => 'phpunit-test',
                'author' => 'SpamBot',
                'authorUrl' => '',
                'komment' => '<p>A spam comment by an evil bot</p>',
                'kommentType' => 'KOMMENT',
                'image' => 'https://www.gravatar.com/avatar/fa5d3b1755664ea7cb3c8ef1e00a5a52',
                'title' => 'phpunit-test',
                'url' => '/panel/pages/phpunit-test',
                'published' => '2021-11-10 13:50',
                'verified' => false,
                'spamlevel' => 100,
                'status' => false
            ],
        ];

        $baseUtils = new KommentBaseUtils();
        $result = $baseUtils->getCommentsOfPage($pageMock, 'pending');

        $this->assertEquals($result, $expectedResult);
        $this->assertCount(2, $result);
    }

    /**
     * @group panel
     * @testdox getCommentsOfPage - should get 1 spam comment
     */
    public function testGetCommentsOfPageOnlySpam()
    {
        $pageMock = $this->getPageMock();
        $expectedResult = [
            [
                'id' => '594a3bdc4947c1a8496d2beb8a065cb1',
                'slug' => 'phpunit-test',
                'author' => 'SpamBot',
                'authorUrl' => '',
                'komment' => '<p>A spam comment by an evil bot</p>',
                'kommentType' => 'KOMMENT',
                'image' => 'https://www.gravatar.com/avatar/fa5d3b1755664ea7cb3c8ef1e00a5a52',
                'title' => 'phpunit-test',
                'url' => '/panel/pages/phpunit-test',
                'published' => '2021-11-10 13:50',
                'verified' => false,
                'spamlevel' => 100,
                'status' => false
            ],
        ];

        $baseUtils = new KommentBaseUtils();
        $result = $baseUtils->getCommentsOfPage($pageMock, 'spam');

        $this->assertEquals($result, $expectedResult);
        $this->assertCount(1, $result);
    }

    /**
     * @group panel
     * @testdox getCommentsCountOfPage - should get 2 comments
     */
    public function testGetPendingCommentsCount()
    {
        $pageMock = $this->getPageMock();

        $baseUtils = new KommentBaseUtils();
        $result = $baseUtils->getCommentsCountOfPage($pageMock, 'pending');

        $this->assertEquals(2, $result);
    }

    /**
     * @group panel
     * @testdox getCommentsCountOfPage - should get 1 spam comment
     */
    public function testGetSpamCommentsCount()
    {
        $pageMock = $this->getPageMock();

        $baseUtils = new KommentBaseUtils();
        $result = $baseUtils->getCommentsCountOfPage($pageMock, 'spam');

        $this->assertEquals(1, $result);
    }
}
