<?php

declare(strict_types=1);

namespace NunoMaduro\LaravelMojito;

use Illuminate\Testing\TestResponse;
use Illuminate\Support\ServiceProvider;

/**
 * @internal
 */
final class MojitoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        TestResponse::macro('assertView', function () {
            return new TestView($this->getContent());
        });
    }
}
