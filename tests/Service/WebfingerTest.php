<?php

declare(strict_types=1);

namespace Surface\LaravelWebfinger\Tests\Service;

use Stringable;
use Surface\LaravelWebfinger\Service\Webfinger as Service;
use Surface\LaravelWebfinger\Tests\TestCase;

final class WebfingerTest extends TestCase
{
    /**
     * @test
     * @dataProvider serviceProvider
     */
    public function toArray(string $instance, string $username, string $actualInstance, string $actualUsername,): void
    {
        $service = new Service($instance, $username);
        $array = $service->toArray();

        $this->assertIsArray($array);
        $this->assertArrayHasKey('instance', $array);
        $this->assertArrayHasKey('username', $array);

        $this->assertInstanceOf(Stringable::class, $array['instance']);
        $this->assertInstanceOf(Stringable::class, $array['username']);

        $this->assertTrue($array['instance']->is($actualInstance));
        $this->assertTrue($array['username']->is($actualUsername));
    }

    /**
     * @test
     * @dataProvider serviceProvider
     */
    public function getter(string $instance, string $username, string $actualInstance, string $actualUsername,): void
    {
        $service = new Service($instance, $username);

        $this->assertInstanceOf(Stringable::class, $service->instance);
        $this->assertInstanceOf(Stringable::class, $service->username);

        $this->assertTrue($service->instance->is($actualInstance));
        $this->assertTrue($service->username->is($actualUsername));
    }

    /** @return array<int, array<int, string>> */
    public static function serviceProvider(): iterable
    {
        return [
            yield ['mastodon.social', 'username', 'https://mastodon.social/', 'username'],
            yield ['https://mastodon.social', 'username', 'https://mastodon.social/', 'username'],
            yield ['https://mastodon.social/', 'username', 'https://mastodon.social/', 'username'],
            yield ['mastodon.social', '@username', 'https://mastodon.social/', 'username'],
            yield ['https://mastodon.social', '@username', 'https://mastodon.social/', 'username'],
            yield ['https://mastodon.social/', '@username', 'https://mastodon.social/', 'username'],
        ];
    }
}
