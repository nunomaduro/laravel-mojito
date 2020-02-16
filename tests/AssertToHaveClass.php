<?php


namespace Tests;

use NunoMaduro\LaravelMojito\InteractsWithViews;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AssertToHaveClass extends TestCase
{
    use InteractsWithViews;

    public function testToHaveClass(): void
    {
        $this->assertView('button')->toHaveClass('btn');
        $this->assertView('welcome')->in('.content')->at('div > div', 0)->toHaveClass('title');
    }

    public function testToNotHaveClass(): void
    {
        $this->expectException(AssertionFailedError::class);

        $this->assertView('button')->toHaveClass('btn-danger');
    }
}
