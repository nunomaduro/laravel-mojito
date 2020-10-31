<p align="center">
    <img src="https://raw.githubusercontent.com/nunomaduro/laravel-mojito/master/docs/example.png" alt="Mojito example" width="80%">
</p>

<p align="center">
  <a href="https://travis-ci.org/nunomaduro/laravel-mojito"><img src="https://img.shields.io/travis/nunomaduro/laravel-mojito/master.svg" alt="Build Status"></img></a>
  <a href="https://packagist.org/packages/nunomaduro/laravel-mojito"><img src="https://poser.pugx.org/nunomaduro/laravel-mojito/d/total.svg" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/nunomaduro/laravel-mojito"><img src="https://poser.pugx.org/nunomaduro/laravel-mojito/v/stable.svg" alt="Latest Version"></a>
  <a href="https://packagist.org/packages/nunomaduro/laravel-mojito"><img src="https://poser.pugx.org/nunomaduro/laravel-mojito/license.svg" alt="License"></a>
</p>

## About Mojito

Mojito was created by, and is maintained by [Nuno Maduro](https://github.com/nunomaduro), and is a lightweight package for testing Laravel views in isolation.

## Installation & Usage

> **Requires [PHP 7.2.5+](https://php.net/releases/)**

Require Mojito using [Composer](https://getcomposer.org):

```bash
composer require nunomaduro/laravel-mojito --dev
```

How to use:

```php
class WelcomeTest extends TestCase
{
    // First, add the `InteractsWithViews` trait to your test case class.
    use InteractsWithViews; 

    public function testDisplaysLaravel()
    {
        // Then, get started with Mojito using the `assertView` method.
        $this->assertView('welcome')->contains('Laravel');
    }
}
```

Optionally, you can also perform view testing from your HTTP Tests:

```php
class WelcomeTest extends TestCase
{
    public function testDisplaysLaravel()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertView()->contains('Laravel');
    }
}
```

### `contains`

Asserts that the view contains the given text.

```php
$this->assertView('button')->contains('Click me');
$this->assertView('button', ['submitText' => 'Cancel'])->contains('Cancel');

$this->assertView('welcome')->in('title')->contains('Laravel');
$this->assertView('welcome')->in('.content')->contains('Nova');
```

### `first`

Filters the view and returns only the first element matching the selector.

```php
$this->assertView('welcome')->first('.links a')->contains('Docs');
```

### `has`

Asserts that the view has the given selector.

```php
$this->assertView('button')->has('button');

$this->assertView('welcome')->has('head');
$this->assertView('welcome')->in('body')->has('.content');
```

### `hasAttribute`

Asserts that the view **root element** has the given attribute value.

```php
$this->assertView('button')->hasAttribute('attribute', 'value');
$this->assertView('button')->hasAttribute('data-attribute', 'value');

$this->assertView('welcome')->hasAttribute('lang', 'en');
$this->assertView('welcome')->in('head')->first('meta')->hasAttribute('charset','utf-8');
```

### `hasClass`

Asserts that the view has an element with the given class.

```php
$this->assertView('button')->hasClass('btn');

$this->assertView('welcome')->in('.content')->at('div > p', 0)->hasClass('title');
```

### `hasLink`

Asserts that the view has an element with the given link.

```php
$this->assertView('button')->hasLink(route('welcome'));

$this->assertView('welcome')->in('.links')->first('a')->hasLink('https://laravel.com/docs');
$this->assertView('welcome')->in('.links')->at('a', 6)->hasLink('https://vapor.laravel.com');
$this->assertView('welcome')->in('.links')->last('a')->hasLink('https://github.com/laravel/laravel');
```

### `in`

Filters the view and returns only the elements matching the selector.

```php
$this->assertView('welcome')->in('.links a')->contains('Laracast');
```

### `last`

Filters the view and returns only the last element matching the selector.

```php
$this->assertView('welcome')->last('.links a')->contains('GitHub');
```

### Macroable

Fell free to add your own macros to the `ViewAssertion::class`.

```php
use NunoMaduro\LaravelMojito\ViewAssertion;

// Within a service provider:
ViewAssertion::macro('hasCharset', function (string $charset) {
    return $this->in('head')->first('meta')->hasAttribute('charset', $charset);
});

// In your tests:
$this->assertView('welcome')->hasCharset('utf-8');
```


## Contributing

Thank you for considering to contribute to Mojito. All the contribution guidelines are mentioned [here](CONTRIBUTING.md).

You can have a look at the [CHANGELOG](CHANGELOG.md) for constant updates & detailed information about the changes. You can also follow the twitter account for latest announcements or just come say hi!: [@enunomaduro](https://twitter.com/enunomaduro)

## Support the development
**Do you like this project? Support it by donating**

- GitHub sponsors: [Donate](https://github.com/sponsors/nunomaduro)
- PayPal: [Donate](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=66BYDWAT92N6L)
- Patreon: [Donate](https://www.patreon.com/nunomaduro)

## License

Mojito is an open-sourced software licensed under the [MIT license](LICENSE.md).
