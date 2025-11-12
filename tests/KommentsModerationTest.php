<?php

use mauricerenck\Komments\KommentModeration;
use mauricerenck\Komments\TestCaseMocked;

final class KommentsModerationTest extends TestCaseMocked
{
    private $avatar = 'https://api.dicebear.com/9.x/pixel-art/png?seed=AuthorName';

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @group moderation
     * @testdox getComment - should return a comment array
     */
    public function testGetComment()
    {
        $moderationClass = new KommentModeration(storageType: 'phpunit');

        $expectedArray = [
            'id' => 'comment-id',
            'pageuuid' => 'page://uzeaX0oDEG6ZYGKS',
            'parentid' => '',
            'type' => 'comment',
            'content' => 'lorem ipsum dolor sit amet.',
            'authorname' => 'Author Name',
            'authoravatar' => $this->avatar,
            'authoremail' => 'author@example.com',
            'authorurl' => 'https://example.com',
            'published' => true,
            'verification_status' => 'PUBLISHED',
            'verified' => false,
            'spamlevel' => 0,
            'language' => null,
            'upvotes' => 0,
            'downvotes' => 0,
            'createdat' => $this->defaultDate,
            'updatedat' => $this->defaultDate,
            'permalink' => '/@/comment/comment-id',
        ];

        $result = $moderationClass->getComment('comment-id');
        $this->assertEquals($expectedArray, $result);
    }

    /**
     * @group moderation
     * @testdox getPendingComments - should return pending comments
     */
    public function testGetPendingComments()
    {
        $moderationClass = new KommentModeration(storageType: 'phpunit');

        $expectedArray = [
            'id' => 'comment-id-2',
            'pageuuid' => 'page://uzeaX0oDEG6ZYGKS',
            'parentid' => '',
            'type' => 'comment',
            'content' => 'lorem ipsum dolor sit amet.',
            'authorname' => 'Author Name',
            'authoravatar' => $this->avatar,
            'authoremail' => 'author@example.com',
            'authorurl' => 'https://example.com',
            'published' => false,
            'verification_status' => 'PUBLISHED',
            'verified' => false,
            'spamlevel' => 0,
            'language' => null,
            'upvotes' => 0,
            'downvotes' => 0,
            'createdat' => $this->defaultDate,
            'updatedat' => $this->defaultDate,
            'permalink' => '/@/comment/comment-id-2',
        ];

        $expected = [
            'comments' => json_encode([$expectedArray]),
            'affectedPages' => [[
                'uuid' => 'page://uzeaX0oDEG6ZYGKS',
                'title' => 'phpunit',
                'panel' => '/panel/pages/phpunit'
            ]]
        ];

        $result = $moderationClass->getPendingComments();
        // $this->assertEquals($expected, $result);
    }

    /**
     * @group moderation
     * @testdox getAllPageComments - should return comments of a page
     */
    public function testGetAllPageComments()
    {
        $moderationClass = new KommentModeration(storageType: 'phpunit');

        $result = $moderationClass->getAllPageComments('page://uzeaX0oDEG6ZYGKS');
        $resultArray = json_decode($result['comments']);

        $this->assertCount(4, $resultArray);
        $this->assertCount(1, $result['affectedPages']);
    }
}
