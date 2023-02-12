# Create an ActivityPub webfinger

This creates a webfinger URL which denotes your profile on ActivityPub.

Once installed you should see your JSON webfinger profile at `/.well-known/webfinger`.


## Installation

You can install the package via composer:

```bash
composer require surface/laravel-webfinger
```

You must add the configuration to your `.env` file:

```bash
WEBFINGER_INSTANCE=activityPub.instance
WEBFINGER_USERNAME=your-username
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Surface\LaravelWebfinger\LaravelWebfingerServiceProvider"
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
