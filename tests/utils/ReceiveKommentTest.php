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
        $isVerified = $kommentReceiver->isVerified('test@phpunit.de');

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
}
