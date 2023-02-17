<?php

namespace Tests;

use NunoMaduro\LaravelMojito\InteractsWithViews;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AssertHasAttribute extends TestCase
{
    use InteractsWithViews;

    public function testHasAttribute(): void
    {
        $this->assertView('button')->hasAttribute('prop', 'value');
        $this->assertView('welcome')->hasAttribute('lang', 'en');
        $this->assertView('welcome')->in('head')->first('meta')->hasAttribute('charset', 'utf-8');
    }

    public function testDoNotHasAttribute(): void
    {
        $html = file_get_contents(__DIR__.'/fixtures/button.html');
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage(
            "Failed asserting that the prop `missing-value` exists within `{$html}`"
        );

        $this->assertView('button')->hasAttribute('prop', 'missing-value');
    }
}
