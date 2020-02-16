<?php


namespace Tests;

use NunoMaduro\LaravelMojito\InteractsWithViews;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AssertIn extends TestCase
{
    use InteractsWithViews;

    public function testToContainIn(): void
    {
        $this->assertView('alert')->in('button')->toHaveClass('btn');
        $this->assertView('welcome')->in('title')->toContain('Laravel');
    }

    public function testNotToContainIn(): void
    {
        $this->expectException(AssertionFailedError::class);

        $this->assertView('alert')->in('something-not-there')->toHaveClass('btn');
    }
}
