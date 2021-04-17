<?php


namespace Tests;

use NunoMaduro\LaravelMojito\InteractsWithViews;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AssertHasMeta extends TestCase
{
    use InteractsWithViews;

    public function testHasMeta(): void
    {
        $this->assertView('welcome')->hasMeta([
            'name'   =>  'viewport',
            'content'   =>  'width=device-width, initial-scale=1'
        ]);

        $this->assertView('welcome')->hasMeta([
            'charset' => 'utf-8'
        ]);
    }

    public function testHasMetaFailure(): void
    {
        $html = file_get_contents(__DIR__.'/fixtures/welcome.html');
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage(
            "Failed asserting that `meta[property='og:title']` exists within `{$html}`"
        );

        $this->assertView('welcome')->hasMeta([
            'property'   =>  'og:title'
        ]);
    }

    public function testDoesNotHaveMeta(): void
    {
        $this->assertView('welcome')->not()->hasMeta([
            'property' => 'og:title'
        ]);
    }


    public function testDoesNotHaveMetaFailure(): void
    {
        $html = file_get_contents(__DIR__.'/fixtures/welcome.html');
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage(
            "Failed asserting that `{$html}` does not have meta `{\"charset\":\"utf-8\"}`"
        );

        $this->assertView('welcome')->not()->hasMeta([
            'charset' => 'utf-8'
        ]);
    }
}
