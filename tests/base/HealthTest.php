<?php
use PHPUnit\Framework\TestCase;

final class HealthTest extends TestCase
{
    public function testShouldHaveTitle()
    {
        $this->assertEquals(site()->title()->value(), 'Plugin');
    }
}
