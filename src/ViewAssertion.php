<?php

declare(strict_types=1);

namespace NunoMaduro\LaravelMojito;

use DOMNode;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Mail\Markdown;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Traits\Macroable;
use NunoMaduro\LaravelMojito\Exceptions\RootElementNotFound;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\AssertionFailedError;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\Test\Constraint\CrawlerSelectorExists;

final class ViewAssertion
{
    use Macroable;

    /**
     * @var \Symfony\Component\DomCrawler\Crawler
     */
    private $crawler;

    /**
     * @var string
     */
    private $html;

    /**
     * Makes a callable that can be used with Mail and Notification assertions
     */
    public static function make(callable $callable) : callable
    {
        return function () use ($callable) : bool {
            $args = func_get_args();

            if (($args[0] ?? false) && $args[0] instanceof Mailable) {
                return $callable(
                    new self(
                        resolve(
                            ViewFactory::class
                        )
                            ->make($args[0]->view, $args[0]->viewData)
                            ->render()
                    )
                );
            } elseif (($args[0] ?? false) && $args[0] instanceof Notification) {
                list($notification, $channel, $notifiable, $locale) = $args;

                $rendered = null;

                $mail =
                    method_exists($notification, 'toMail') ?
                        $notification->toMail($notifiable) :
                        null;
                if ($mail instanceof Mailable) {
                    $rendered = new self(
                        resolve(
                            ViewFactory::class
                        )
                            ->make($mail->view, $mail->viewData)
                            ->render()
                    );
                } elseif ($mail instanceof MailMessage) {
                    if ($mail->view) {
                        $rendered = new self(
                            resolve(
                                ViewFactory::class
                            )
                                ->make($mail->view, $mail->viewData)
                                ->render()
                        );
                    } else {
                        $rendered = new self(
                            (string) resolve(Markdown::class)
                                ->render($mail->markdown, $mail->data())
                        );
                    }
                } else {
                    return false;
                }

                return $callable(
                    $rendered,
                    $channel,
                    $notifiable,
                    $locale
                );
            }

            return false;
        };
    }

    /**
     * Create a new view assertion instance.
     */
    public function __construct(string $html)
    {
        $this->html = $html;

        $this->crawler = new Crawler($this->html);

        // If the view is not a full HTML document, the Crawler will try to fix it
        // adding an html and a body tag, so we need to crawl back down
        // to the relevant portion of HTML
        if (strpos($html, '</html>') === false) {
            $this->crawler = $this->crawler->children()->children();
        }
    }

    /**
     * Creates a new view assertion with the given selector.
     */
    public function in(string $selector): ViewAssertion
    {
        $this->has($selector);

        $filteredHtml = $this->crawler->children()->filter($selector)->each(function ($node) {
            return $node->outerHtml();
        });

        return new self(collect($filteredHtml)->implode(''));
    }

    /**
     * Creates a new view assertion with the given selector at the given position.
     */
    public function at(string $selector, int $position): ViewAssertion
    {
        $node = $this->crawler->filter($selector)->eq($position);

        return new self($node->outerHtml());
    }

    /**
     * Creates a new view assertion with the given selector at the first position.
     */
    public function first(string $selector): ViewAssertion
    {
        $node = $this->crawler->filter($selector)->first();

        return new self($node->outerHtml());
    }

    /**
     * Creates a new view assertion with the given selector at the last position.
     *
     * @return ViewAssertion
     */
    public function last(string $selector): ViewAssertion
    {
        $node = $this->crawler->filter($selector)->last();

        return new self($node->outerHtml());
    }

    /**
     * Asserts that the view contains the given text.
     */
    public function contains(string $text): ViewAssertion
    {
        self::assert(function () use ($text) {
            Assert::assertStringContainsString((string) $text, $this->html);
        }, "Failed asserting that the text `$text` exists within %s.");

        return $this;
    }

    /**
     * Asserts that the view, at the **root element**, contains the given attribute value.
     */
    public function hasAttribute(string $attribute, string $value): ViewAssertion
    {
        self::assert(function () use ($attribute, $value) {
            Assert::assertSame($value, $this->getRootElement()->getAttribute($attribute));
        }, "Failed asserting that the $attribute `$value` exists within %s.");

        return $this;
    }

    /**
     * Asserts that the view contains an element with the given class.
     */
    public function hasClass(string $class): ViewAssertion
    {
        return $this->has(".$class");
    }

    /**
     * Asserts that the view contains an element with the given link.
     */
    public function hasLink(string $link): ViewAssertion
    {
        return $this->has("a[href='$link']");
    }

    /**
     * Asserts that the view contains the given selector.
     */
    public function has(string $selector): ViewAssertion
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
            throw new AssertionFailedError(sprintf($message, sprintf("`%s`", $this->html)));
        }
    }
}
