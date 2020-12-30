<?php
use mauricerenck\Komments\KommentBaseUtils;
use PHPUnit\Framework\TestCase;
use Kirby\Cms;
use c;

final class UtilsBaseTest extends TestCase
{
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
}
