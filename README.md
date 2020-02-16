<p align="center">
    <img src="https://raw.githubusercontent.com/nunomaduro/laravel-mojito/master/docs/example.png" alt="Mojito example" height="300">
</p>

<p align="center">
  <a href="https://travis-ci.org/nunomaduro/laravel-mojito"><img src="https://img.shields.io/travis/nunomaduro/laravel-mojito/master.svg" alt="Build Status"></img></a>
  <a href="https://packagist.org/packages/nunomaduro/laravel-mojito"><img src="https://poser.pugx.org/nunomaduro/laravel-mojito/d/total.svg" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/nunomaduro/laravel-mojito"><img src="https://poser.pugx.org/nunomaduro/laravel-mojito/v/stable.svg" alt="Latest Version"></a>
  <a href="https://packagist.org/packages/nunomaduro/laravel-mojito"><img src="https://poser.pugx.org/nunomaduro/laravel-mojito/license.svg" alt="License"></a>
</p>

## About Mojito

Mojito was created by, and is maintained by [Nuno Maduro](https://github.com/nunomaduro), and is an view testing library for Laravel.

## Installation & Usage

> **Requires [PHP 7.2+](https://php.net/releases/)**

Create your package using [Composer](https://getcomposer.org):

```bash
composer require nunomaduro/laravel-mojito
```

How to use:

```php
class WelcomeTest extends TestCase
{
    // First, add the `InteractsWithViews` trait to your test case class.
    use InteractsWithViews; 

    public function testDisplaysLaravel(): void
    {
        // Then, get started with Mojito using the `assertView` method.
        $this->assertView('welcome')->toContain('Laravel');
    }
}
```

### `toHave` vs `toContain`

- `toHave` concerns always the root element of the view.
- `toContain` concerns the entire view, including sub elements

### `toContain`

```php
// with partials
$this->assertView('button')->toContain('Click me');
$this->assertView('button', ['submitText' => 'Cancel'])->toContain('Cancel');

$this->assertView('welcome')->in('title')->toContain('Laravel');
$this->assertView('welcome')->in('.content')->toContain('Nova');
```

Asserts that the **entire view** contains the given raw text.

### `toContainSelector`

```php
$this->assertView('button')->toContainSelector('button');

$this->assertView('welcome')->toContainSelector('head');
```

Asserts that the **entire view** contains the given selector.

### `toHave`

```php
$this->assertView('button')->toHave('attribute', 'value');
$this->assertView('button')->toHave('data-attribute', 'value');

$this->assertView('welcome')->toHave('lang', 'en');
```

Asserts that the view **root element** contains the given attribute value.

### `toHaveClass`

```php
$this->assertView('button')->toHaveClass('btn');

$this->assertView('welcome')->in('.content')->at('div > p', 0)->toHaveClass('title');
```

Asserts that the view **root element** contains the given class.

### `toHaveLink`

```php
$this->assertView('button')->toHaveLink(route('welcome'));

$this->assertView('welcome')->in('.links')->first('a')->toHaveLink('https://laravel.com/docs');
$this->assertView('welcome')->in('.links')->at('a', 6)->toHaveLink('https://vapor.laravel.com');
$this->assertView('welcome')->in('.links')->last('a')->toHaveLink('https://github.com/laravel/laravel');
```

Asserts that the view **root element** contains the given link.

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
