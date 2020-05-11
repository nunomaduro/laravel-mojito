<?php

namespace Tests;

use Illuminate\View\View;

/**
 * @internal
 */
final class FakeView extends View
{
    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function render(callable $callback = null): string
    {
        return (string) file_get_contents(
            __DIR__ . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . $this->name . '.html'
        );
    }
}
