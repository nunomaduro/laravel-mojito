<?php

namespace Tests;

use NunoMaduro\LaravelMojito\InteractsWithViews;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class Misc extends TestCase
{
    use InteractsWithViews;

    public function testPercentageSymbolDoesNotBreakAssertions(): void
    {
        $html = file_get_contents(__DIR__.'/fixtures/button.html');
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage(
            "Failed asserting that the text `This text has a percentage 43% symbol` exists within `{$html}`"
        );

        $this->assertView('button')->contains('This text has a percentage 43% symbol');
    }
}
