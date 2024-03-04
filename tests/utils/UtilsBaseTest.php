<?php

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

    /**
     * @group base
     * @testdox getPageFromSlug - should get a page with the slug 'phpunit'
     */
    public function testGetPageFromSlug()
    {
        $pageMock = $this->getPageMock();
        $baseUtils = new KommentBaseUtils();

        $result = $baseUtils->getPageFromSlug('phpunit');
        $this->assertEquals($result->title()->raw(), 'phpunit');
    }

    /**
     * @group base
     * @testdox getPageFromSlug - should handle unkown page
     */
    public function testGetPageUnknownFromSlug()
    {
        $pageMock = $this->getPageMock();
        $baseUtils = new KommentBaseUtils();

        $result = $baseUtils->getPageFromSlug('unknown');
        $this->assertFalse($result);
    }

    /**
     * @group base
     * @testdox getAllCommentsOfPage - should get all inboxes of page
     */
    public function testGetAllInboxesOfMultilangPage()
    {
        $pageMock = $this->getPageMock();
        $baseUtils = new KommentBaseUtils();
        $result = $baseUtils->getAllCommentsOfPage($pageMock);

        $this->assertEquals(3, $result->count());
    }

    /**
     * @group base
     * @testdox getAllCommentsOfPage - should get a single inbox with language de
     */
    public function testGetAllCommentsOfSingleLangPage()
    {
        $pageMock = $this->getPageMock();

        $baseUtils = new KommentBaseUtils(['de']);
        $result = $baseUtils->getAllCommentsOfPage($pageMock);

        $this->assertEquals(1, $result->count());
    }

    /**
     * @group base
     * @testdox getAllCommentsOfPage - should get a single inbox without language
     */
    public function testGetAllCommentsOfNoLangPage()
    {
        $pageMock = $this->getPageMock();

        $kommentsFrontend = new KommentBaseUtils([]);
        $result = $kommentsFrontend->getAllCommentsOfPage($pageMock);

        $this->assertEquals(3, $result->count());
    }

    /**
     * @group base
     * @testdox filterCommentsByType - should get all types of comments
     */
    public function testFilterCommentsByType()
    {
        $pageMock = $pageMock = $this->getPageMock(false, [
            'kommentsInbox' => '
            -
              author: Unknown user
              avatar: >
                https://www.gravatar.com/avatar/c67cfe10182e385fcd4181c06334a527
              authorurl: ""
              authoremail: ""
              kommenttype: REPLY
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
              kommenttype: LIKE
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

        $baseUtils = new KommentBaseUtils();
        $inbox = $baseUtils->getAllCommentsOfPage($pageMock);
        $result = $baseUtils->filterCommentsByType($inbox);

        $this->assertEquals(3, $result->count());
    }

    /**
     * @group base
     * @testdox filterCommentsByType - should get comments only
     */
    public function testFilterCommentsByTypeKomment()
    {
        $pageMock = $pageMock = $this->getPageMock(false, [
            'kommentsInbox' => '
            -
              author: Unknown user
              avatar: >
                https://www.gravatar.com/avatar/c67cfe10182e385fcd4181c06334a527
              authorurl: ""
              authoremail: ""
              kommenttype: REPLY
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
              kommenttype: LIKE
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

        $baseUtils = new KommentBaseUtils();
        $inbox = $baseUtils->getAllCommentsOfPage($pageMock);
        $result = $baseUtils->filterCommentsByType($inbox, 'KOMMENT');

        $this->assertEquals(1, $result->count());
    }

    /**
     * @group base
     * @testdox filterCommentsByType - should get likes only
     */
    public function testFilterCommentsByTypeLike()
    {
        $pageMock = $pageMock = $this->getPageMock(false, [
            'kommentsInbox' => '
                -
                  author: Unknown user
                  avatar: >
                    https://www.gravatar.com/avatar/c67cfe10182e385fcd4181c06334a527
                  authorurl: ""
                  authoremail: ""
                  kommenttype: REPLY
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
                  kommenttype: LIKE
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

        $baseUtils = new KommentBaseUtils();
        $inbox = $baseUtils->getAllCommentsOfPage($pageMock);
        $result = $baseUtils->filterCommentsByType($inbox, 'LIKE');

        $this->assertEquals(1, $result->count());
    }

    /**
     * @group base
     * @testdox filterCommentsByType - should get replies only
     */
    public function testFilterCommentsByTypeReply()
    {
        $pageMock = $pageMock = $this->getPageMock(false, [
            'kommentsInbox' => '
                -
                  author: Unknown user
                  avatar: >
                    https://www.gravatar.com/avatar/c67cfe10182e385fcd4181c06334a527
                  authorurl: ""
                  authoremail: ""
                  kommenttype: REPLY
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
                  kommenttype: LIKE
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

        $baseUtils = new KommentBaseUtils();
        $inbox = $baseUtils->getAllCommentsOfPage($pageMock);
        $result = $baseUtils->filterCommentsByType($inbox, 'REPLY');

        $this->assertEquals(1, $result->count());
    }

    /**
     * @group base
     * @testdox filterCommentsByStatus - should get all comments
     */
    public function testFilterCommentsByStatus()
    {
        $pageMock = $pageMock = $this->getPageMock(false, [
            'kommentsInbox' => '
                -
                  author: Unknown user
                  avatar: >
                    https://www.gravatar.com/avatar/c67cfe10182e385fcd4181c06334a527
                  authorurl: ""
                  authoremail: ""
                  kommenttype: REPLY
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
                  kommenttype: LIKE
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

        $baseUtils = new KommentBaseUtils();
        $inbox = $baseUtils->getAllCommentsOfPage($pageMock);
        $result = $baseUtils->filterCommentsByStatus($inbox);

        $this->assertEquals(3, $result->count());
    }

    /**
     * @group base
     * @testdox filterCommentsByStatus - should get all published comments
     */
    public function testFilterCommentsByStatusPublished()
    {
        $pageMock = $pageMock = $this->getPageMock(false, [
            'kommentsInbox' => '
                -
                  author: Unknown user
                  avatar: >
                    https://www.gravatar.com/avatar/c67cfe10182e385fcd4181c06334a527
                  authorurl: ""
                  authoremail: ""
                  kommenttype: REPLY
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
                  kommenttype: LIKE
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

        $baseUtils = new KommentBaseUtils();
        $inbox = $baseUtils->getAllCommentsOfPage($pageMock);
        $result = $baseUtils->filterCommentsByStatus($inbox, 'published');

        $this->assertEquals(1, $result->count());
    }

    /**
     * @group base
     * @testdox filterCommentsByStatus - should get all pending comments
     */
    public function testFilterCommentsByStatusPending()
    {
        $pageMock = $pageMock = $this->getPageMock(false, [
            'kommentsInbox' => '
                -
                  author: Unknown user
                  avatar: >
                    https://www.gravatar.com/avatar/c67cfe10182e385fcd4181c06334a527
                  authorurl: ""
                  authoremail: ""
                  kommenttype: REPLY
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
                  kommenttype: LIKE
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

        $baseUtils = new KommentBaseUtils();
        $inbox = $baseUtils->getAllCommentsOfPage($pageMock);
        $result = $baseUtils->filterCommentsByStatus($inbox, 'pending');

        $this->assertEquals(2, $result->count());
    }

    /**
     * @group base
     * @testdox filterCommentsByStatus - should get all spam comments
     */
    public function testFilterCommentsByStatusSpam()
    {
        $pageMock = $pageMock = $this->getPageMock(false, [
            'kommentsInbox' => '
                -
                  author: Unknown user
                  avatar: >
                    https://www.gravatar.com/avatar/c67cfe10182e385fcd4181c06334a527
                  authorurl: ""
                  authoremail: ""
                  kommenttype: REPLY
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
                  kommenttype: LIKE
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

        $baseUtils = new KommentBaseUtils();
        $inbox = $baseUtils->getAllCommentsOfPage($pageMock);
        $result = $baseUtils->filterCommentsByStatus($inbox, 'spam');

        $this->assertEquals(1, $result->count());
    }

    /**
     * @group panel
     * @testdox getCommentsCountOfPage - should count 3 comments
     */
    public function testGetCommentsCount()
    {
        $pageMock = $this->getPageMock();

        $baseUtils = new KommentBaseUtils();
        $result = $baseUtils->getCommentsCountOfPage($pageMock);

        $this->assertEquals(3, $result);
    }

    /**
     * @group panel
     * @testdox getCommentsCountOfPage - should count 1 spam comment
     */
    public function testGetCommentsCountSpam()
    {
        $pageMock = $this->getPageMock();

        $baseUtils = new KommentBaseUtils();
        $result = $baseUtils->getCommentsCountOfPage($pageMock, 'spam');

        $this->assertEquals(1, $result);
    }

    /**
     * @group panel
     * @testdox getCommentsCountOfPage - should count 2 pending comment
     */
    public function testGetCommentsCountPending()
    {
        $pageMock = $this->getPageMock();

        $baseUtils = new KommentBaseUtils();
        $result = $baseUtils->getCommentsCountOfPage($pageMock, 'pending');

        $this->assertEquals(2, $result);
    }
    /**
     * @group base
     * @testdox getInboxByLanguage - should get english inbox with 3 comments
     */
    public function testGetInboxByLanguageEn()
    {
        $pageMock = $this->getPageMock();

        $baseUtils = new KommentBaseUtils();
        $result = $baseUtils->getInboxByLanguage($pageMock, 'en');
        $structure = $result->toStructure();

        $this->assertEquals(3, $structure->count());
    }

    /**
     * @group base
     * @testdox getInboxByLanguage - should get german inbox with 1 comments
     */
    public function testGetInboxByLanguageDe()
    {
        $pageMock = $this->getPageMock();

        $baseUtils = new KommentBaseUtils();
        $result = $baseUtils->getInboxByLanguage($pageMock, 'de');
        $structure = $result->toStructure();

        $this->assertEquals(1, $structure->count());
    }

    /**
     * @group base
     * @testdox getInboxByLanguage - should handle query without language
     */
    public function testGetInboxByLanguageUnknown()
    {
        $pageMock = $this->getPageMock();

        $baseUtils = new KommentBaseUtils();
        $result = $baseUtils->getInboxByLanguage($pageMock, null);
        $structure = $result->toStructure();

        $this->assertEquals(3, $structure->count());
    }

    /**
     * @group base
     * @testdox getCommentsCountOfPage - should get 3 comments
     */
    public function testGetCommentsCountOfPage()
    {
        $pageMock = $this->getPageMock();

        $baseUtils = new KommentBaseUtils();
        $result = $baseUtils->getCommentsCountOfPage($pageMock);

        $this->assertEquals(3, $result);
    }

    /**
     * @group base
     * @testdox getCommentsCountOfPage - should count 1 published comment
     */
    public function testGetCommentsCountOfPagePublished()
    {
        $pageMock = $this->getPageMock();

        $baseUtils = new KommentBaseUtils();
        $result = $baseUtils->getCommentsCountOfPage($pageMock, 'published');

        $this->assertEquals(1, $result);
    }

    /**
     * @group base
     * @testdox getCommentsCountOfPage - should count 1 pending comment
     */
    public function testGetCommentsCountOfPagePending()
    {
        $pageMock = $this->getPageMock();

        $baseUtils = new KommentBaseUtils();
        $result = $baseUtils->getCommentsCountOfPage($pageMock, 'pending');

        $this->assertEquals(2, $result);
    }

    /**
     * @group base
     * @testdox getCommentsCountOfPage - should count 1 spam comment
     */
    public function testGetCommentsCountOfPageSpam()
    {
        $pageMock = $this->getPageMock();

        $baseUtils = new KommentBaseUtils();
        $result = $baseUtils->getCommentsCountOfPage($pageMock, 'spam');

        $this->assertEquals(1, $result);
    }
}
