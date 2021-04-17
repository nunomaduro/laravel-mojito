<?php


namespace Tests;

use NunoMaduro\LaravelMojito\InteractsWithViews;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AssertHasClass extends TestCase
{
    use InteractsWithViews;

    public function testHasClass(): void
    {
        $this->assertView('button')->hasClass('btn');
        $this->assertView('welcome')->in('.content')->at('div > div', 0)->hasClass('title');
    }

    public function testHasClassFailure(): void
    {
        $html = file_get_contents(__DIR__.'/fixtures/button.html');
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage(
            "Failed asserting that `.btn-danger` exists within `{$html}`"
        );

        $this->assertView('button')->hasClass('btn-danger');
    }

    public function testDoesNotHaveClass(): void
    {
        $this->assertView('button')->not()->hasClass('btn-danger');
    }

    public function testDoesNotHaveClassFailure(): void
    {
        $html = file_get_contents(__DIR__.'/fixtures/button.html');
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage(
            "Failed asserting that `{$html}` does not have class `btn`"
        );

        $this->assertView('button')->not()->hasClass('btn');
    }
}
