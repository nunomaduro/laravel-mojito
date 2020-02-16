<?php


namespace Tests;

use NunoMaduro\LaravelMojito\InteractsWithViews;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AssertToHaveLink extends TestCase
{
    use InteractsWithViews;

    public function testToHaveLink(): void
    {
        $this->assertView('button')->toHaveLink('https://link.com');
        $this->assertView('welcome')->in('.links')->first('a')->toHaveLink('https://laravel.com/docs');
        $this->assertView('welcome')->in('.links')->at('a', 6)->toHaveLink('https://vapor.laravel.com');
        $this->assertView('welcome')->in('.links')->last('a')->toHaveLink('https://github.com/laravel/laravel');

    }

    public function testToNotHaveLink(): void
    {
        $this->expectException(AssertionFailedError::class);

        $this->assertView('button')->toHaveLink('https://link-that-is-not-there.com');
    }
}
