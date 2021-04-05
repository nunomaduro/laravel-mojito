<?php


namespace Tests;

use NunoMaduro\LaravelMojito\InteractsWithViews;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AssertNotEmpty extends TestCase
{
    use InteractsWithViews;

    public function testEmpty(): void
    {
        $this->assertView('button')->in('.btn')->notEmpty();
    }

    public function testNotEmpty(): void
    {
        $this->expectException(AssertionFailedError::class);

        $this->assertView('empty')->in('.empty-div')->notEmpty();
    }
}
