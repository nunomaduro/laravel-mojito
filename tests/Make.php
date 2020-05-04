<?php

namespace Tests;

use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NunoMaduro\LaravelMojito\InteractsWithViews;
use NunoMaduro\LaravelMojito\ViewAssertion;
use PHPUnit\Framework\TestCase;

final class Make extends TestCase
{
    use InteractsWithViews;

    public function testItProcessesMailableAssertions() : void
    {
        $callable = ViewAssertion::make(function (ViewAssertion $assertion) {
            $assertion->contains('Laravel');

            return true;
        });


        $mailable = new class('email', []) extends Mailable {
            public function __construct(string $view, array $viewData)
            {
                $this->view = $view;
                $this->viewData = $viewData;
            }
        };

        $callable($mailable);
    }

    public function testItProcessesNotificationProvidingMarkdownMailMessagesIntoViewAssertable() : void
    {
        $notification = new class extends Notification {
            public function toMail() : MailMessage
            {
                return (new MailMessage());
            }
        };

        $notifiable = new \stdClass();

        $callable = ViewAssertion::make(function (
            ViewAssertion $assertion,
            $channel,
            $notifiableInstance,
            $locale
        ) use ($notifiable) {
            $assertion->contains('Laravel');
            $this->assertSame($notifiable, $notifiableInstance);
            $this->assertSame('mail', $channel);
            $this->assertSame('en', $locale);

            return true;
        });

        $callable($notification, 'mail', $notifiable, 'en');
    }

    public function testItProcessesNotificationProvidingViewMailMessagesIntoViewAssertable() : void
    {
        $notification = new class extends Notification {
            public function toMail() : MailMessage
            {
                return (new MailMessage())->view('email');
            }
        };

        $notifiable = new \stdClass();

        $callable = ViewAssertion::make(function (
            ViewAssertion $assertion,
            $channel,
            $notifiableInstance,
            $locale
        ) use ($notifiable) {
            $assertion->contains('Laravel');
            $this->assertSame($notifiable, $notifiableInstance);
            $this->assertSame('mail', $channel);
            $this->assertSame('en', $locale);

            return true;
        });

        $callable($notification, 'mail', $notifiable, 'en');
    }

    public function testItProcessesNotificationMailableIntoViewAssertable() : void
    {
        $notification = new class extends Notification {
            public function toMail() : Mailable
            {
                return new class('email', []) extends Mailable {
                    public function __construct(string $view, array $viewData)
                    {
                        $this->view = $view;
                        $this->viewData = $viewData;
                    }
                };
            }
        };

        $notifiable = new \stdClass();

        $callable = ViewAssertion::make(function (
            ViewAssertion $assertion,
            $channel,
            $notifiableInstance,
            $locale
        ) use ($notifiable) {
            $assertion->contains('Laravel');
            $this->assertSame($notifiable, $notifiableInstance);
            $this->assertSame('mail', $channel);
            $this->assertSame('en', $locale);

            return true;
        });

        $callable($notification, 'mail', $notifiable, 'en');
    }
}
