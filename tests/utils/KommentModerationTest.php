<?php

use mauricerenck\Komments\KommentBaseUtils;
use mauricerenck\Komments\KommentModeration;
use mauricerenck\Komments\TestCaseMocked;

final class KommentModerationTest extends TestCaseMocked
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testShouldGetPendingKomments()
    {
        $commentModeration = new KommentModeration();
        $pendingComments = $commentModeration->getSiteWideComments('pending');

        $this->assertIsArray($pendingComments);
        $this->assertCount(3, $pendingComments);
    }

    public function testShouldHaveDifferentKommentTypes()
    {
        $commentModeration = new KommentModeration();
        $pendingComments = $commentModeration->getSiteWideComments('pending');

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

    /**
     * @group panel
     * @testdox getCommentsOfPage - should get 3 comments
     */
    public function testGetCommentsOfPage()
    {
        $pageMock = $this->getPageMock();
        $commentModeration = new KommentModeration();

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
                'status' => false,
                'mentionof' => 'https://komments.test:8890/phpunit',
                'replies' => [],
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
                'status' => true,
                'mentionof' => 'https://komments.test:8890/phpunit',
                'replies' => [],
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
                'status' => false,
                'mentionof' => 'https://komments.test:8890/phpunit',
                'replies' => [],
            ],
        ];

        $result = $commentModeration->getCommentsOfPage($pageMock);
        $this->assertEquals($result, $expectedResult);
    }

    /**
     * @group panel
     * @testdox getCommentsOfPage - should get 1 published comments
     */
    public function testGetPublishedCommentsOfPage()
    {
        $pageMock = $this->getPageMock();
        $commentModeration = new KommentModeration();

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
                'status' => true,
                'mentionof' => 'https://komments.test:8890/phpunit',
                'replies' => [],
            ],
        ];

        $result = $commentModeration->getCommentsOfPage($pageMock, 'published');
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
              spamlevel: 100',
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
                'status' => false,
                'mentionof' => 'https://komments.test:8890/phpunit',
                'replies' => [],
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
                'status' => false,
                'mentionof' => 'https://komments.test:8890/phpunit',
                'replies' => [],
            ],
        ];

        $commentModeration = new KommentModeration();
        $result = $commentModeration->getCommentsOfPage($pageMock, 'pending');

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
                'status' => false,
                'mentionof' => 'https://komments.test:8890/phpunit',
                'replies' => [],
            ],
        ];

        $commentModeration = new KommentModeration();
        $result = $commentModeration->getCommentsOfPage($pageMock, 'spam');

        $this->assertEquals($result, $expectedResult);
        $this->assertCount(1, $result);
    }

    /**
     * @group panel
     * @testdox convertInboxToCommentArray - should convert comment to panel comment array
     */
    public function testConvertSingleInboxCommentToCommentArray()
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
                'status' => false,
                'mentionof' => 'https://komments.test:8890/phpunit',
                'replies' => [],
            ],
        ];

        $commentModeration = new KommentModeration();
        $baseUtils = new KommentBaseUtils();
        $inbox = $baseUtils->getAllCommentsOfPage($pageMock);
        $filteredInbox = $baseUtils->filterCommentsByStatus($inbox, 'spam');

        $result = $commentModeration->convertInboxToCommentArray($filteredInbox, $pageMock);

        $this->assertEquals($result, $expectedResult);
    }

    /**
     * @group panel
     * @testdox convertInboxToCommentArray - should convert to panel comment array
     */
    public function testConvertInboxToCommentArray()
    {
        $pageMock = $this->getPageMock();
        $commentModeration = new KommentModeration();
        $baseUtils = new KommentBaseUtils();

        $inbox = $baseUtils->getAllCommentsOfPage($pageMock);
        $result = $commentModeration->convertInboxToCommentArray($inbox, $pageMock);

        $this->assertEquals(count($result), 3);
    }

    /**
     * @group panel
     * @testdox convertInboxToCommentArray - should convert to panel comment array
     */
     public function testMarkAsSpam()
     {
         $pageMock = $this->getPageMock();
         $baseUtilsMock = Mockery::mock('mauricerenck\Komments\KommentBaseUtils[getAllCommentsOfPage]');
         $commentModeration = new KommentModeration();


         $inbox = $baseUtils->getAllCommentsOfPage($pageMock);

         $this->assertEquals($comment['status'], 'spam');
     }
}
