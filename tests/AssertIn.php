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

    public function testIn(): void
    {
        $this->assertView('alert')->in('button')->hasClass('btn');
        $this->assertView('welcome')->in('title')->contains('Laravel');
    }

    public function testDoNotIn(): void
    {
        $this->expectException(AssertionFailedError::class);

        $this->assertView('alert')->in('something-not-there')->hasClass('btn');
    }
}
