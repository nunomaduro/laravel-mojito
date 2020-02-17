<?php

declare(strict_types=1);

namespace NunoMaduro\LaravelMojito;

use Illuminate\Support\ServiceProvider;

/**
 * @internal
 */
final class MojitoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $macro = function () {
            return new ViewAssertion($this->getContent());
        };

        if (class_exists(\Illuminate\Testing\TestResponse::class)) {
            \Illuminate\Testing\TestResponse::macro('assertView', $macro);
        } else {
            \Illuminate\Foundation\Testing\TestResponse::macro('assertView', $macro);
        }
    }
}
