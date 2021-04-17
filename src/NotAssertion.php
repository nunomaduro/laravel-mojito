<?php

declare(strict_types=1);

namespace NunoMaduro\LaravelMojito;

use PHPUnit\Framework\ExpectationFailedException;

final class NotAssertion
{
    /**
     * @var ViewAssertion
     */
    protected $originalAssertion;

    /**
     * Create a new inverted view assertion instance.
     */
    public function __construct(ViewAssertion $originalAssertion)
    {
        $this->originalAssertion = $originalAssertion;
    }

    /**
     * Return the original assertion when not is called twice
     */
    public function not() : ViewAssertion
    {
        return $this->originalAssertion;
    }

    /**
     * @throws \UnexpectedValueException
     */
    public function in(string $selector): ViewAssertion
    {
        throw new \UnexpectedValueException(
            "Cannot use `in()` after `not()`. `not()` must be followed by an assertion."
        );
    }

    /**
     * @throws \UnexpectedValueException
     */
    public function at(string $selector, int $position): ViewAssertion
    {
        throw new \UnexpectedValueException(
            "Cannot use `at()` after `not()`. `not()` must be followed by an assertion."
        );
    }

    /**
     * @throws \UnexpectedValueException
     */
    public function first(string $selector): ViewAssertion
    {
        throw new \UnexpectedValueException(
            "Cannot use `first()` after `not()`. `not()` must be followed by an assertion."
        );
    }

    /**
     * @throws \UnexpectedValueException
     */
    public function last(string $selector): ViewAssertion
    {
        throw new \UnexpectedValueException(
            "Cannot use `last()` after `not()`. `not()` must be followed by an assertion."
        );
    }

    /**
     * Reverse the next assertion
     * @throws ExpectationFailedException
     */
    public function __call(string $name, array $arguments): ViewAssertion
    {
        try {
            $this->originalAssertion->$name(...$arguments);
        } catch (ExpectationFailedException $e) {
            return $this->originalAssertion;
        }

        throw new ExpectationFailedException($this->getErrorMessage($name, $arguments));
    }

    /**
     * Create an error message for the failed assertion, trying to make sense
     * from the original name and arguments.
     */
    private function getErrorMessage(string $name, array $arguments): string
    {
        $name = collect(preg_split('/(?=[A-Z])/', $name))
            ->map(function ($word, $key) {
                if (strtolower($word) === 'has') {
                    return 'have';
                }
                return ($key === 0)
                    ? preg_replace("/s\b/", "", strtolower($word))
                    : strtolower($word);
            })
            ->implode(' ');


        if (empty($arguments)) {
            return 'Failed asserting that `'
                . $this->originalAssertion->getHtml()
                . '` is not '.$name;
        }

        $arguments = array_map(
            function ($item) {
                return is_array($item) ? json_encode($item) : $item;
            },
            (array) $arguments
        );

        if (count($arguments) === 2) {
            return 'Failed asserting that `'
                . $this->originalAssertion->getHtml()
                . '` does not ' . $name
                . ' `' . $arguments[0] . ' = ' . $arguments[1] . '`';
        }

        return 'Failed asserting that `'
            . $this->originalAssertion->getHtml()
            . '` does not ' . $name
            . ' `' . implode(', ', $arguments) . '`';
    }
}
