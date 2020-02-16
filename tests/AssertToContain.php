<?php


namespace Tests;

use NunoMaduro\LaravelMojito\InteractsWithViews;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AssertToContain extends TestCase
{
    use InteractsWithViews;

    public function testToContain(): void
    {
        $this->assertView('button')->toContain('Click me');
        $this->assertView('welcome')->toContain('<title>Laravel</title>');
    }

    public function testDoNotContain(): void
    {
        $this->expectException(AssertionFailedError::class);

        $this->assertView('button')->toContain('Do not click me');
    }
}
