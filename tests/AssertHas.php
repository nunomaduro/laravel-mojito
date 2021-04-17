<?php


namespace Tests;

use NunoMaduro\LaravelMojito\InteractsWithViews;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AssertHas extends TestCase
{
    use InteractsWithViews;

    public function testHas(): void
    {
        $this->assertView('alert')->has('button');
        $this->assertView('welcome')->has('head');
        $this->assertView('welcome')->in('body')->has('.content');
    }

    public function testHasFailure(): void
    {
        $html = file_get_contents(__DIR__.'/fixtures/alert.html');
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage(
            "Failed asserting that `form` exists within `{$html}`"
        );

        $this->assertView('alert')->has('form');
    }

    public function testDoesNotHave(): void
    {
        $this->assertView('welcome')->not()->has('main');
        $this->assertView('welcome')->in('body')->not()->has('.invalid');
    }

    public function testDoesNotHaveFailure(): void
    {
        $html = file_get_contents(__DIR__.'/fixtures/alert.html');
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage(
            "Failed asserting that `{$html}` does not have `button`"
        );
        $this->assertView('alert')->not()->has('button');
    }
}
