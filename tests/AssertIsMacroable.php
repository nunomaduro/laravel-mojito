<?php

namespace Tests;

use NunoMaduro\LaravelMojito\InteractsWithViews;
use NunoMaduro\LaravelMojito\ViewAssertion;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AssertIsMacroable extends TestCase
{
    use InteractsWithViews;

    public function setUp(): void
    {
        parent::setUp();

        ViewAssertion::macro('hasCharset', function (string $charset) {
            return $this->in('head')->first('meta')->hasAttribute('charset', $charset);
        });
    }

    public function testHasCharset(): void
    {
        $this->assertView('welcome')->hasCharset('utf-8');
    }

    public function testHasCharsetFailure(): void
    {
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage(
            'Failed asserting that the charset `not-valid` exists within `<meta charset="utf-8">'
        );

        $this->assertView('welcome')->hasCharset('not-valid');
    }

    public function testDoesNotHaveCharset(): void
    {
        $this->assertView('welcome')->not()->hasCharset('utf-16');
    }

    public function testDoesNotHaveCharsetFailure(): void
    {
        $html = file_get_contents(__DIR__.'/fixtures/welcome.html');

        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage(
            "Failed asserting that `{$html}` does not have charset `utf-8`"
        );

        $this->assertView('welcome')->not()->hasCharset('utf-8');
    }
}
