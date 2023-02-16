# Create a Webfinger in Laravel

This creates a [webfinger](https://webfinger.net), a way to attach information
to an email address, or an other online resource. Once installed you should see
your JSON webfinger profile at `/.well-known/webfinger`.

## Installation

You can install the package via composer:

```bash
composer require surface/laravel-webfinger
```

You must add the configuration to your `.env` file:

```bash
WEBFINGER_INSTANCE=mastodon.instance
WEBFINGER_USERNAME=your-username
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Surface\LaravelWebfinger\LaravelWebfingerServiceProvider"
```

## Extending the Resource

The resource which is converted to the JSON response is bound to the service
container. This allows you to easily override the resource and add extra
information. To change the binding, add the following to your app service
provider.

```php
use App\Http\Resources\Webfinger as WebfingerResource;
use Surface\LaravelWebfinger\Http\Resources\Webfinger as PackageWebfinger;
use Surface\LaravelWebfinger\Service\Webfinger as WebfingerService;

$this->app->bind(
    PackageWebfinger::class,
    static fn (Container $app): WebfingerResource => new WebfingerResource(
        ...$app->make(WebfingerService::class)
    )
);
```

Then you would create your custom resource which extends the base.

```php
<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Stringable;
use Surface\LaravelWebfinger\Http\Resources\Webfinger as JsonResource;

class Webfinger extends JsonResource
{
    protected string $website;

    public function __construct(protected Stringable $instance, protected Stringable $username)
    {
        parent::__construct($instance, $username);

        $this->website = 'https://www.example.com';
    }

    public function links(Request $request): array
    {
        return [
            ...parent::links($request),
            [
                'rel' => 'self',
                'type' => 'text/html',
                'href' => $this->website,
            ],
        ];
    }
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed
recently.

## Credits

- [Trevor Morris](https://github.com/trovster)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more
information.
