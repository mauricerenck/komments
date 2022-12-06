<?php
use mauricerenck\Komments\KommentBaseUtils;
use PHPUnit\Framework\TestCase;
use Kirby\Cms;

final class UtilsBaseTest extends TestCase
{
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

    public function testShouldGetPluginVersion()
    {
        $baseUtils = new KommentBaseUtils();
        $this->assertIsArray($baseUtils->getPluginVersion());
    }

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

    public function testNeverExpireByDefault()
    {
        $pageMock = $this->getMockBuilder(Page::class)
            ->enableProxyingToOriginalMethods();

        $baseUtils = new KommentBaseUtils();
        $this->assertEquals(0, $baseUtils->kommentsAreExpired($pageMock));
    }

    public function testShouldNotBeExpired()
    {
        $pageMock = $this->getMockBuilder(Page::class)
            ->enableProxyingToOriginalMethods();

        c::set('mauricerenck.komments.auto-disable-komments', 10);
        $baseUtils = new KommentBaseUtils();
        $this->assertEquals(0, $baseUtils->kommentsAreExpired($pageMock));
    }

    public function testReturnCommentCount()
    {
        $pageMock = $this->getMockBuilder(Page::class)
            ->enableProxyingToOriginalMethods();

        $baseUtils = new KommentBaseUtils();
        $this->assertEquals(3, $baseUtils->getPendingCommentCount());
    }

    public function testReturnSpamCommentCount()
    {
        $pageMock = $this->getMockBuilder(Page::class)
            ->enableProxyingToOriginalMethods();

        $baseUtils = new KommentBaseUtils();
        $this->assertEquals(1, $baseUtils->getSpamCommentCount());
    }
}
