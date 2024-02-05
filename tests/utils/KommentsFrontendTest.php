<?php

use Kirby\Cms\Language;
use mauricerenck\Komments\KommentsFrontend;
use mauricerenck\Komments\TestCaseMocked;
use Kirby\Cms\Languages;

final class KommentsFrontendTest extends TestCaseMocked
{

    private $frontendUtilsMock;
    private $baseUtilsMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->frontendUtilsMock = Mockery::mock('mauricerenck\Komments\KommentsFrontend[getAllInboxesOfPage]');
        $this->baseUtilsMock = Mockery::mock('mauricerenck\Komments\KommentBaseUtils[getAllLanguages]');

    }

    /**
     * @group frontend
     * @testdox kommentsAreExpired - should be expired
     */
    public function testKommentsAreExpired() {
        $pageMock = $this->getPageMock(false, ['date' => '2019-01-01']);
        $kommentsFrontend = new KommentsFrontend(1, 'date');
        $result = $kommentsFrontend->kommentsAreExpired($pageMock);
        $this->assertTrue($result);
    }

    /**
     * @group frontend
     * @testdox kommentsAreExpired - should not be expired
     */
    public function testKommentsAreNotExpired() {
        $pageMock = $this->getPageMock(false, ['date' => '2035-01-01']);
        $kommentsFrontend = new KommentsFrontend(1, 'date');
        $result = $kommentsFrontend->kommentsAreExpired($pageMock);
        $this->assertFalse($result);
    }

    /**
     * @group frontend
     * @testdox kommentsAreExpired - should handle missing date field
     */
    public function testKommentsAreExpiredMissingDateField() {
        $pageMock = $this->getPageMock(false, ['date' => '2035-01-01']);
        $kommentsFrontend = new KommentsFrontend(1, 'dateNotExisting');
        $result = $kommentsFrontend->kommentsAreExpired($pageMock);
        $this->assertFalse($result);
    }

    /**
     * @group frontend
     * @testdox kommentsAreExpired - should handle wrong type of date field
     */
    public function testKommentsAreExpiredWrongTypeOfDateField() {
        $pageMock = $this->getPageMock(false, ['date' => '2035-01-01']);
        $kommentsFrontend = new KommentsFrontend(1, 'textfield');
        $result = $kommentsFrontend->kommentsAreExpired($pageMock);
        $this->assertFalse($result);
    }

    /**
     * @group frontend
     * @testdox getAllInboxesOfPage - should get all inboxes of page
     */
    public function testGetAllInboxesOfMultilangPage() {
        $pageMock = $this->getPageMock();
        $kommentsFrontend = new KommentsFrontend();
        $result = $kommentsFrontend->getAllInboxesOfPage($pageMock);

        $this->assertEquals(3, $result->count());
    }

    /**
     * @group frontend
     * @testdox getAllInboxesOfPage - should get a single inbox with language de
     */
    // public function testGetAllInboxesOfSingleLangPage() {
    //     $pageMock = $this->getPageMock();
    //     $languageMock = new Language(['code' => 'de', 'default' => true]);
    //     $languagesMock = new Languages([$languageMock]);

    //     // FIXME dieser mock funktioniert nicht
    //     $this->baseUtilsMock->shouldReceive('getAllLanguages')->andReturn($languagesMock);

    //     $kommentsFrontend = new KommentsFrontend();
    //     $result = $kommentsFrontend->getAllInboxesOfPage($pageMock);

    //     $this->assertEquals(1, $result->count());
    // }

    /**
     * @group frontend
     * @testdox getAllInboxesOfPage - should get a single inbox without language
     */
    // public function testGetAllInboxesOfNoLangPage() {
    //     $pageMock = $this->getPageMock();
    //     $this->baseUtilsMock->shouldReceive('getAllLanguages')->andReturn(null);

    //     $kommentsFrontend = new KommentsFrontend();
    //     $result = $kommentsFrontend->getAllInboxesOfPage($pageMock);

    //     $this->assertEquals(1, $result->count());
    // }

    
    /**
     * @group frontend
     * @testdox getAllInboxesOfPage - should get 3 comments
     */
    // public function testGetCommentsOfPage()
    // {
    //     $pageMock = $this->getPageMock();
    //     $this->frontendUtilsMock->shouldReceive('storeProcessedUrls')->andReturn(true);

    //     $frontendUtils = new KommentsFrontend();

        

    //     $result = $this->frontendUtilsMock->getAllInboxesOfPage($pageMock);
    //     $this->assertEquals($result, $expectedResult);
    // }

}
