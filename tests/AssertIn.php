<?php

namespace Tests;

use NunoMaduro\LaravelMojito\InteractsWithViews;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AssertIn extends TestCase
{
    use InteractsWithViews;

    public function testIn(): void
    {
        $this->assertView('alert')->in('button')->hasClass('btn');
        $this->assertView('welcome')->in('title')->contains('Laravel');
        $this->assertView('welcome')->in('.links a')->contains('Laracast');
    }

    public function testNotIn(): void
    {
        $html = file_get_contents(__DIR__.'/fixtures/alert.html');
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage(
            "Failed asserting that `something-not-there` exists within `{$html}`"
        );

        $this->assertView('alert')->in('something-not-there')->hasClass('btn');
    }
}
