<?php


namespace Tests;

use NunoMaduro\LaravelMojito\InteractsWithViews;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AssertContains extends TestCase
{
    use InteractsWithViews;

    public function testContains(): void
    {
        $this->assertView('button')->contains('Click me');
        $this->assertView('welcome')->contains('<title>Laravel</title>');
    }

    public function testDoNotContains(): void
    {
        $this->expectException(AssertionFailedError::class);

        $this->assertView('button')->contains('Do not click me');
    }
}
