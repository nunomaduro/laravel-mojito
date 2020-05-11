<?php

namespace Tests;

use NunoMaduro\LaravelMojito\InteractsWithViews;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AssertFirst extends TestCase
{
    use InteractsWithViews;

    public function testFirst(): void
    {
        $this->assertView('welcome')->first('.links a')->contains('Docs');
    }

    public function testNotFirst(): void
    {
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage(
            'Failed asserting that the text `Laracase` exists within `<a href="https://laravel.com/docs">Docs</a>`.'
        );

        $this->assertView('welcome')->first('.links a')->contains('Laracase');
    }
}
