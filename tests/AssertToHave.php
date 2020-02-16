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
        $this->assertView('welcome')->in('head')->first('meta')->toHave('charset','utf-8');
    }

    public function testToNotHave(): void
    {
        $this->expectException(AssertionFailedError::class);

        $this->assertView('button')->toHave('prop', 'missing-value');
    }
}
