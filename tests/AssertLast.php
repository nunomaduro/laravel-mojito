<?php

namespace Tests;

use NunoMaduro\LaravelMojito\InteractsWithViews;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AssertLast extends TestCase
{
    use InteractsWithViews;

    public function testLast(): void
    {
        $this->assertView('welcome')->last('.links a')->contains('GitHub');
    }

    public function testNotLast(): void
    {
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage(
            'Failed asserting that the text `Laracase` exists within '
            .'`<a href="https://github.com/laravel/laravel">GitHub</a>`.'
        );

        $this->assertView('welcome')->last('.links a')->contains('Laracase');
    }
}
