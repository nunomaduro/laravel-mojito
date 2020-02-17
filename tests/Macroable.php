<?php


namespace Tests;


use NunoMaduro\LaravelMojito\InteractsWithViews;
use NunoMaduro\LaravelMojito\TestView;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

final class Macroable extends TestCase
{
    use InteractsWithViews;

    public function testCanApplyMacros(): void
    {
        TestView::macro('hasCharset', function (string $charset) {
            return $this->in('head')->first('meta')->hasAttribute('charset', $charset);
        });

        $this->assertView('welcome')->hasCharset('utf-8');

        $this->expectException(AssertionFailedError::class);

        $this->assertView('welcome')->hasCharset('not-valid');
    }
}
