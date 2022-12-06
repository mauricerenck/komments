<?php
use mauricerenck\Komments\KommentReceiver;
use PHPUnit\Framework\TestCase;
use Kirby\Cms;
use Kirby\Toolkit\Config;

final class ReceiveKommentTest extends TestCase
{
    public function testMarkKnownUserAsVerified()
    {
        $kommentReceiver = new KommentReceiver();
        kirby()->impersonate('test@phpunit.de');
        $isVerified = $kommentReceiver->isVerified('test@phpunit.de');
        kirby()->impersonate(null);

        $this->assertTrue($isVerified);
    }

    public function testMarkUnknownUserAsUnverified()
    {
        $kommentReceiver = new KommentReceiver();
        $isVerified = $kommentReceiver->isVerified('unknown@phpunit.de');

        $this->assertFalse($isVerified);
    }

    public function testMarkInvalidEmailAsUnverified()
    {
        $kommentReceiver = new KommentReceiver();
        $isVerified = $kommentReceiver->isVerified('invalid_phpunit.de');

        $this->assertFalse($isVerified);
    }

    public function testAutoPublishKnownAddress()
    {
        $kommentReceiver = new KommentReceiver();
        $isVerified = $kommentReceiver->autoPublish('test@phpunit.de');

        $this->assertTrue($isVerified);
    }
    public function testAutoPublishUnknownAddress()
    {
        $kommentReceiver = new KommentReceiver();
        $isVerified = $kommentReceiver->autoPublish('unknown@phpunit.de');

        $this->assertFalse($isVerified);
    }
}
