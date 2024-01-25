<?php

use mauricerenck\Komments\KommentsFrontend;
use mauricerenck\Komments\TestCaseMocked;


final class KommentsFrontendTest extends TestCaseMocked
{

    private $frontendUtilsMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->frontendUtilsMock = Mockery::mock('mauricerenck\Komments\KommentsFrontend[getAllInboxesOfPage]');

    }

    /**
     * @group panel
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
