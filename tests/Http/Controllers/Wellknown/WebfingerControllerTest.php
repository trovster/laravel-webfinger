<?php

declare(strict_types=1);

namespace Surface\LaravelWebfinger\Tests\Http\Controllers\Wellknown;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Testing\Fluent\AssertableJson;
use Surface\LaravelWebfinger\Http\Controllers\Wellknown\WebfingerController as Controller;
use Surface\LaravelWebfinger\Tests\TestCase;

final class WebfingerControllerTest extends TestCase
{
    /** @test */
    public function controller(): void
    {
        $request = $this->app->make(Request::class);
        $this->assertInstanceOf(Request::class, $request);

        $controller = $this->app->make(Controller::class);
        $this->assertInstanceOf(Controller::class, $controller);

        $response = $this->app->call($controller, [
            'request' => $request,
        ]);

        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    /** @test */
    public function isOk(): void
    {
        $this->get('/.well-known/webfinger')
            ->assertOk()
            ->assertJson(static fn (AssertableJson $json): AssertableJson => $json
                ->where('subject', 'acct:username@activitypub.instance')
                ->hasAll([
                    'subject',
                    'aliases' => 2,
                    'links' => 3,
                ])
                ->whereAllType([
                    'subject' => 'string',
                    'aliases' => 'array',
                    'links' => 'array',
                ]));
    }
}
