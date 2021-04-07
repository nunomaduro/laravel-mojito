<?php


namespace Tests;

use NunoMaduro\LaravelMojito\InteractsWithViews;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AssertEmpty extends TestCase
{
    use InteractsWithViews;

    public function testEmpty(): void
    {
        $this->assertView('empty')->in('.empty-div')->empty();
        $this->assertView('empty')->in('.empty-with-empty-nodes')->empty();
        $this->assertView('empty')->in('.empty-with-space')->empty();
    }

    public function testNotEmpty(): void
    {
        $this->expectException(AssertionFailedError::class);

        $this->assertView('empty')->in('.not-empty')->empty();
    }
}
