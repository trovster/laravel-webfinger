<?php

declare(strict_types=1);

namespace Surface\LaravelWebfinger\Http\Controllers\Wellknown;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Surface\LaravelWebfinger\Http\Resources\Webfinger as Resource;

final class WebfingerController extends Controller
{
    public function __construct(protected Resource $resource)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        return $this->resource->toResponse($request);
    }
}
