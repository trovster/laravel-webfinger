<?php

declare(strict_types=1);

namespace Surface\LaravelWebfinger\Http\Controllers\Wellknown;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Surface\LaravelWebfinger\Http\Resources\Webfinger;
use Surface\LaravelWebfinger\Service\Webfinger as Service;

final class WebfingerController extends Controller
{
    public function __construct(protected Service $service)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        return Webfinger::make(...$this->service->toArray())->toResponse($request);
    }
}
