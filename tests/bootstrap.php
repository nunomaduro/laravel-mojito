<?php

use Illuminate\Contracts\View\Factory;
use Illuminate\Mail\Markdown;
use Tests\FakeView;
use Tests\FakeViewFactory;

function view(string $name, array $_a, array $_b): FakeView
{
    return new FakeView($name);
}

if (! function_exists('resolve')) {
    function resolve(string $resolvable)
    {
        $view = new FakeViewFactory();

        if ($resolvable === Markdown::class) {
            return new Markdown($view);
        } elseif ($resolvable === Factory::class) {
            return $view;
        }

        throw new InvalidArgumentException('Resolvable is not configured for ' . $resolvable);
    }
}
