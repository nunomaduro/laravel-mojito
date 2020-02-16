<?php


namespace Tests;

use NunoMaduro\LaravelMojito\InteractsWithViews;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AssertToHave extends TestCase
{
    use InteractsWithViews;

    public function testToHave(): void
    {
        $this->assertView('button')->toHave('prop', 'value');
        $this->assertView('welcome')->toHave('lang', 'en');

    }

    public function testToNotHave(): void
    {
        $this->expectException(AssertionFailedError::class);

        $this->assertView('button')->toHave('prop', 'missing-value');
    }
}
