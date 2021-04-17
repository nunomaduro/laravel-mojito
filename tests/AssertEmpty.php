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

    public function testEmptyFailure(): void
    {
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage(
            "Failed asserting that the text `Hello` is empty"
        );

        $this->assertView('empty')->in('.not-empty-text')->empty();
    }

    public function testNotEmpty(): void
    {
        $this->assertView('button')->in('.btn')->not()->empty();
    }

    public function testNotEmptyFailure(): void
    {
        $html = '<div class="empty-div"></div>';
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage(
            "Failed asserting that `{$html}` is not empty"
        );

        $this->assertView('empty')->in('.empty-div')->not()->empty();
    }
}
