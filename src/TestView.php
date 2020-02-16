<?php

namespace NunoMaduro\LaravelMojito;

use DOMNode;
use NunoMaduro\LaravelMojito\Exceptions\RootElementNotFound;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\AssertionFailedError;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\Test\Constraint\CrawlerSelectorExists;

/**
 * @internal
 */
final class TestView
{
    /**
     * @var \Symfony\Component\DomCrawler\Crawler
     */
    private $crawler;

    /**
     * Create a new test view instance.
     */
    public function __construct(string $html)
    {
        $this->crawler = new Crawler($html);

        if (strpos($html, '</html>') === false) {
            $this->crawler = $this->crawler->children()->children();
        }
    }

    /**
     * Creates a new test view with the given selector.
     */
    public function in(string $selector): TestView
    {
        $this->has($selector);

        return new self($this->crawler->children()->filter($selector)->outerHtml());
    }

    /**
     * Creates a new test view with the given selector at the given position.
     */
    public function at(string $selector, int $position): TestView
    {
        $node = $this->crawler->filter($selector)->eq($position);

        return new self($node->outerHtml());
    }

    /**
     * Creates a new test view with the given selector at the first position.
     */
    public function first(string $selector): TestView
    {
        $node = $this->crawler->filter($selector)->first();

        return new self($node->outerHtml());
    }

    /**
     * Creates a new test view with the given selector at the last position.
     *
     * @return TestView
     */
    public function last(string $selector): TestView
    {
        $node = $this->crawler->filter($selector)->last();

        return new self($node->outerHtml());
    }

    /**
     * Asserts that the view contains the given text.
     */
    public function contains(string $text): TestView
    {
        self::assert(function () use ($text) {
            Assert::assertStringContainsString((string) $text, $this->crawler->outerHtml());
        }, "Failed asserting that the text `$text` exists within %s.");

        return $this;
    }

    /**
     * Asserts that the view, at the **root element**, contains the given attribute value.
     */
    public function hasAttribute(string $attribute, string $value): TestView
    {
        self::assert(function () use ($attribute, $value) {
            Assert::assertSame($value, $this->getRootElement()->getAttribute($attribute));
        }, "Failed asserting that the $attribute `$value` exists within %s.");

        return $this;
    }

    /**
     * Asserts that the view contains an element with the given class.
     */
    public function hasClass(string $class): TestView
    {
        return $this->has(".$class");
    }

    /**
     * Asserts that the view contains an element with the given link.
     */
    public function hasLink(string $link): TestView
    {
        return $this->has("a[href='$link']");
    }

    /**
     * Asserts that the view contains the given selector.
     */
    public function has(string $selector): TestView
    {
        self::assert(function () use ($selector) {
            Assert::assertThat($this->crawler, new CrawlerSelectorExists($selector));
        }, "Failed asserting that `$selector` exists within %s.");

        return $this;
    }

    /**
     * Returns the node of the current root element.
     *
     * @return DOMNode
     */
    private function getRootElement(): DOMNode
    {
        $node = $this->crawler->getNode(0);

        if ($node === null) {
            throw new RootElementNotFound($this->crawler->outerHtml());
        }

        return $node;
    }

    /**
     * Runs the given assertion, and fires the given error message on error.
     */
    private function assert(callable $assertion, string $message): void
    {
        try {
            $assertion();
        } catch (AssertionFailedError $e) {
            throw new AssertionFailedError(sprintf($message, sprintf("`%s`", $this->crawler->outerHtml())));
        }
    }
}
