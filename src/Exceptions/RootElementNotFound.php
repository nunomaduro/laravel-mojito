<?php

namespace NunoMaduro\LaravelMojito\Exceptions;

use InvalidArgumentException;

/**
 * @internal
 */
final class RootElementNotFound extends InvalidArgumentException
{
    public function __construct(string $html)
    {
        parent::__construct(sprintf('The given view `%s` do not contain an root element.', $html));
    }
}
