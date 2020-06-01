<?php

declare(strict_types=1);

namespace NunoMaduro\LaravelMojito\Exceptions;

use InvalidArgumentException;

/**
 * @internal
 */
final class RootElementNotFound extends InvalidArgumentException
{
    public function __construct(string $html)
    {
        parent::__construct("The given view `{$html}` do not contain a root element.");
    }
}
