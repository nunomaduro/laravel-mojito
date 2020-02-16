<?php

declare(strict_types=1);

namespace NunoMaduro\LaravelMojito;

trait InteractsWithViews
{
    /**
     * Create a new view test case.
     */
    protected function assertView(string $view, array $data = [], array $mergeData = []): TestView
    {
        return new TestView(view($view, $data, $mergeData)->render());
    }
}
