<?php

declare(strict_types=1);

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Surface\LaravelWebfinger\Http\Controllers\Wellknown\WebfingerController;

Route::prefix('.well-known')->group(static function (Router $router): void {
    $router->get('/webfinger', WebfingerController::class)->name('webfinger');
});
