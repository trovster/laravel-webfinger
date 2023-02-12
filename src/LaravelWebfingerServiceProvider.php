<?php

declare(strict_types=1);

namespace Surface\LaravelWebfinger;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Surface\LaravelWebfinger\Http\Resources\Webfinger as Resource;
use Surface\LaravelWebfinger\Service\Webfinger as Service;

class LaravelWebfingerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->bootConfig();
        $this->bootRoutes();
        $this->bindService();
    }

    protected function bootConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/webfinger.php', 'webfinger');

        $this->publishes([
            __DIR__ . '/../config/webfinger.php' => config_path('webfinger.php'),
        ]);
    }

    protected function bootRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }

    protected function bindService(): void
    {
        $this->app->bind(
            Service::class,
            static function (Application $app): Service {
                /** @var \Illuminate\Config\Repository $config */
                $config = $app->get('config');

                /** @var array<string, string> $items */
                $items = $config->get('webfinger', []);

                return new Service(...$items);
            }
        );

        $this->app->bind(
            Resource::class,
            static function (Application $app): Resource {
                /** @var \Surface\LaravelWebfinger\Service\Webfinger $service */
                $service = $app->make(Service::class);

                return new Resource(...$service);
            }
        );
    }
}
