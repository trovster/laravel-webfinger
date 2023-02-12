<?php

declare(strict_types=1);

namespace Surface\LaravelWebfinger;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Surface\LaravelWebfinger\Service\Webfinger;

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
            Webfinger::class,
            static fn () => new Webfinger(...Config::get('webfinger', []))
        );
    }
}
