<?php

declare(strict_types=1);

namespace Surface\LaravelWebfinger\Tests;

use Illuminate\Support\Facades\Config;
use Orchestra\Testbench\TestCase as Orchestra;
use Surface\LaravelWebfinger\LaravelWebfingerServiceProvider;

abstract class TestCase extends Orchestra
{
    /** @var \Illuminate\Foundation\Application $app */
    protected $app;

    /** @param \Illuminate\Foundation\Application $app */
    public function getEnvironmentSetUp($app): void
    {
        Config::set('webfinger.instance', 'activitypub.instance');
        Config::set('webfinger.username', 'username');
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            LaravelWebfingerServiceProvider::class,
        ];
    }
}
