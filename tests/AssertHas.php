<?php


namespace Tests;

use NunoMaduro\LaravelMojito\InteractsWithViews;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AssertHas extends TestCase
{
    use InteractsWithViews;

    public function testHas(): void
    {
        $this->assertView('alert')->has('button');
        $this->assertView('welcome')->has('head');
    }

    public function testDoNotHas(): void
    {
        $this->expectException(AssertionFailedError::class);

        $this->assertView('alert')->has('form');
    }
}
