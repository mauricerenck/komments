<?php

namespace mauricerenck\Komments;

use Kirby\Cms\Page;
use Kirby\Uuid\Uuid;
use PHPUnit\Framework\TestCase;
use Kirby\Toolkit\Obj;

class TestCaseMocked extends TestCase
{
    public $defaultDate = '2024-01-02 10:00:00';

    public function setUp(): void
    {
        parent::setUp();

        $existingPage = page('phpunit-test');
        if (!is_null($existingPage)) {
            kirby()->impersonate('kirby');
            $existingPage->delete(true);
        }
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $existingPage = page('phpunit-test');
        if (!is_null($existingPage)) {
            kirby()->impersonate('kirby');
            $existingPage->delete(true);
        }
    }

    function getPageMock($draft = false, $contentEN = [], $contentDE = [])
    {
        $defaultContentEN = [
            'Textfield' => "Hello World",
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
              verification_status: "PENDING"
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
              verification_status: "PENDING"
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
              verification_status: "PENDING"
              verified: "false"
              id: 594a3bdc4947c1a8496d2beb8a065cb1
              spamlevel: 100'
        ];

        $pageContentEN = array_merge($defaultContentEN, $contentEN);

        $defaultContentDE = [
            'Textfield' => "Hello World",
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
            verification_status: "PUBLISHED"
            verified: "false"
            id: 1bfffa3f189b3c5b5d6f3ed3271d3342
            spamlevel: 0'
        ];

        $pageContentDE = array_merge($defaultContentDE, $contentDE);


        $pageMock = Page::factory([
            'blueprint' => ['phpunit'],
            'dirname' => 'phpunit-test',
            'slug' => 'phpunit-test',
            'isDraft' => $draft,
            'template' => 'phpunit',
            'translations' => [
                'en' => [
                    'code' => 'en',
                    'content' => $pageContentEN,
                    'uuid'  => Uuid::generate(),
                ],
                'de' => [
                    'code' => 'de',
                    'content' => $pageContentDE,
                ],
                'fr' => [
                    'code' => 'fr',
                    'content' => [],
                ],
            ]
        ]);

        return $pageMock;
    }

    function getCommentMock(array $comment = []): Obj
    {
        $defaultComment = [
            'id' => 'comment-id',
            'pageUuid' => 'page://uzeaX0oDEG6ZYGKS', // phpunit page
            'parentId' => '',
            'type' => 'comment',
            'content' => 'lorem ipsum dolor sit amet.',
            'authorName' => 'Author Name',
            'authorAvatar' => 'https://api.dicebear.com/9.x/pixel-art/png?seed=AuthorName',
            'authorEmail' => 'author@example.com',
            'authorUrl' => 'https://example.com',
            'published' => true,
            'verification_status' => 'PUBLISHED',
            'verified' => false,
            'spamlevel' => 0,
            'language' => null,
            'upvotes' => 0,
            'downvotes' => 0,
            'createdAt' => '2024-01-02 10:00:00',
            'updatedAt' => '2024-01-02 10:00:00',
        ];

        $comment = array_merge($defaultComment, $comment);

        return new Obj([
            'id' => $comment['id'],
            'page_uuid' => $comment['pageUuid'],
            'parent_id' => $comment['parentId'],
            'type' => $comment['type'],
            'content' => $comment['content'],
            'author_name' => $comment['authorName'],
            'author_avatar' => $comment['authorAvatar'],
            'author_email' => $comment['authorEmail'],
            'author_url' => $comment['authorUrl'],
            'published' => $comment['published'],
            'verification_status' => $comment['verification_status'],
            'verified' => $comment['verified'],
            'spamlevel' => $comment['spamlevel'],
            'language' => $comment['language'],
            'upvotes' => $comment['upvotes'],
            'downvotes' => $comment['downvotes'],
            'created_at' => $comment['createdAt'],
            'updated_at' => $comment['updatedAt'],
            'permalink' => '/@/comment/' . $comment['id'],
        ]);
    }
}
