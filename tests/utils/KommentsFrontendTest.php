<?php

use mauricerenck\Komments\KommentsFrontend;
use mauricerenck\Komments\TestCaseMocked;

final class KommentsFrontendTest extends TestCaseMocked
{
    private $frontendUtilsMock;
    private $baseUtilsMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->frontendUtilsMock = Mockery::mock('mauricerenck\Komments\KommentsFrontend[getAllCommentsOfPage]');
        $this->baseUtilsMock = Mockery::mock('mauricerenck\Komments\KommentBaseUtils[getAllLanguages]');
    }

    /**
     * @group frontend
     * @testdox kommentsAreExpired - should be expired
     */
    public function testKommentsAreExpired()
    {
        $pageMock = $this->getPageMock(false, ['date' => '2019-01-01']);
        $kommentsFrontend = new KommentsFrontend(1, 'date');
        $result = $kommentsFrontend->kommentsAreExpired($pageMock);
        $this->assertTrue($result);
    }

    /**
     * @group frontend
     * @testdox kommentsAreExpired - should not be expired
     */
    public function testKommentsAreNotExpired()
    {
        $pageMock = $this->getPageMock(false, ['date' => '2035-01-01']);
        $kommentsFrontend = new KommentsFrontend(1, 'date');
        $result = $kommentsFrontend->kommentsAreExpired($pageMock);
        $this->assertFalse($result);
    }

    /**
     * @group frontend
     * @testdox kommentsAreExpired - should handle missing date field
     */
    public function testKommentsAreExpiredMissingDateField()
    {
        $pageMock = $this->getPageMock(false, ['date' => '2035-01-01']);
        $kommentsFrontend = new KommentsFrontend(1, 'dateNotExisting');
        $result = $kommentsFrontend->kommentsAreExpired($pageMock);
        $this->assertFalse($result);
    }

    /**
     * @group frontend
     * @testdox kommentsAreExpired - should handle wrong type of date field
     */
    public function testKommentsAreExpiredWrongTypeOfDateField()
    {
        $pageMock = $this->getPageMock(false, ['date' => '2035-01-01']);
        $kommentsFrontend = new KommentsFrontend(1, 'textfield');
        $result = $kommentsFrontend->kommentsAreExpired($pageMock);
        $this->assertFalse($result);
    }
}
