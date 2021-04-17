<?php


namespace Tests;

use NunoMaduro\LaravelMojito\InteractsWithViews;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AssertHasLink extends TestCase
{
    use InteractsWithViews;

    public function testHasLink(): void
    {
        $this->assertView('button')->hasLink('https://link.com');
        $this->assertView('welcome')->in('.links')->first('a')->hasLink('https://laravel.com/docs');
        $this->assertView('welcome')->in('.links')->at('a', 6)->hasLink('https://vapor.laravel.com');
        $this->assertView('welcome')->in('.links')->last('a')->hasLink('https://github.com/laravel/laravel');
    }

    public function testHasLinkFailure(): void
    {
        $html = file_get_contents(__DIR__.'/fixtures/button.html');
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage(
            "Failed asserting that `a[href='https://link-that-is-not-there.com']` exists within `{$html}`"
        );

        $this->assertView('button')->hasLink('https://link-that-is-not-there.com');
    }

    public function testDoesNotHaveLink(): void
    {
        $this->assertView('button')->not()->hasLink('https://link-that-is-not-there.com');
    }

    public function testDoesNotHaveLinkFailure(): void
    {
        $html = file_get_contents(__DIR__.'/fixtures/button.html');
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage(
            "Failed asserting that `{$html}` does not have link `https://link.com`"
        );

        $this->assertView('button')->not()->hasLink('https://link.com');
    }
}
