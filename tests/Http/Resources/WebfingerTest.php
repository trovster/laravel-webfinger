<?php

declare(strict_types=1);

namespace Surface\LaravelWebfinger\Tests\Http\Resources;

use Illuminate\Http\Request;
use Surface\LaravelWebfinger\Http\Resources\Webfinger as Resource;
use Surface\LaravelWebfinger\Service\Webfinger as Service;
use Surface\LaravelWebfinger\Tests\TestCase;

final class WebfingerTest extends TestCase
{
    /**
     * @test
     * @dataProvider resourceProvider
     */
    public function resourceShape(string $instance, string $username): void
    {
        $request = $this->app->make(Request::class);
        $this->assertInstanceOf(Request::class, $request);

        $service = new Service($instance, $username);

        $resource = new Resource($service->instance, $service->username);
        $array = $resource->toArray($request);

        $this->assertIsArray($array);
        $this->assertArrayHasKey('subject', $array);
        $this->assertArrayHasKey('aliases', $array);
        $this->assertArrayHasKey('links', $array);

        $this->assertIsString($array['subject']);
        $this->assertIsArray($array['aliases']);
        $this->assertIsArray($array['links']);
    }

    /**
     * @test
     * @param array<int, string> $aliases
     * @dataProvider resourceProvider
     */
    public function resourceSubjectAndAliases(string $instance, string $username, string $subject, array $aliases): void
    {
        $request = $this->app->make(Request::class);
        $this->assertInstanceOf(Request::class, $request);

        $service = new Service($instance, $username);

        $resource = new Resource($service->instance, $service->username);
        $array = $resource->toArray($request);

        $this->assertSame($array['subject'], $subject);
        $this->assertSame($array['aliases'], $aliases);
    }

    /** @return array<int, array<int, array<int, string>|string>> */
    public static function resourceProvider(): iterable
    {
        return [
            yield ['mastodon.social', 'username', 'acct:username@mastodon.social', [
                'https://mastodon.social/@username',
                'https://mastodon.social/users/username',
            ]],
            yield ['https://mastodon.social/', '@username', 'acct:username@mastodon.social', [
                'https://mastodon.social/@username',
                'https://mastodon.social/users/username',
            ]],
        ];
    }
}
