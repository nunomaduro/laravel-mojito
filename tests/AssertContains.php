<?php


namespace Tests;

use NunoMaduro\LaravelMojito\InteractsWithViews;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AssertContains extends TestCase
{
    use InteractsWithViews;

    public function testContains(): void
    {
        $this->assertView('button')->contains('Click me');
        $this->assertView('button', ['submitText' => 'Cancel'])->contains('Cancel');
        $this->assertView('welcome')->contains('<title>Laravel</title>');
    }

    public function testDoesNotContain(): void
    {
        $this->expectException(AssertionFailedError::class);

        $this->assertView('button')->contains('Do not click me');
    }

    public function testContainsInViewWithMultipleRootNodes(): void
    {
        $this->assertView('multiple')
            ->contains('FIRST_PARAGRAPH')
            ->contains('SECOND_PARAGRAPH');
    }

    public function testContainsInViewWithMAlformedHtml(): void
    {
        $this->assertView('malformed')
            ->contains('BEFORE')
            ->contains('AFTER')
            ->contains('WIDGETBEF')
            ->contains('WIDGETAFT');
    }
}
