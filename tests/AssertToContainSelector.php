<?php


namespace Tests;

use NunoMaduro\LaravelMojito\InteractsWithViews;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AssertToContainSelector extends TestCase
{
    use InteractsWithViews;

    public function testToHaveSelector(): void
    {
        $this->assertView('alert')->toContainSelector('button');
        $this->assertView('welcome')->toContainSelector('head');
    }

    public function testToNotHaveSelector(): void
    {
        $this->expectException(AssertionFailedError::class);

        $this->assertView('alert')->toContainSelector('form');
    }
}
