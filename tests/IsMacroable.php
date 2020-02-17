<?php

namespace Tests;

use NunoMaduro\LaravelMojito\InteractsWithViews;
use NunoMaduro\LaravelMojito\ViewAssertion;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

final class IsMacroable extends TestCase
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

    public function testDoNotHasCharset(): void
    {
        $this->expectException(AssertionFailedError::class);

        $this->assertView('welcome')->hasCharset('not-valid');
    }
}
