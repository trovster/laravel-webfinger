<?php

declare(strict_types=1);

namespace Surface\LaravelWebfinger\Service;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

/**
 * @property \Illuminate\Support\Stringable $instance
 * @property \Illuminate\Support\Stringable $username
 */
class Webfinger
{
    protected Stringable $instance;
    protected Stringable $username;

    public function __construct(string $instance, string $username)
    {
        $this->instance = Str::of($instance)->finish('/')->start('https://');
        $this->username = Str::of($username)->ltrim('@');
    }

    /** @return array<string, \Illuminate\Support\Stringable> */
    public function toArray(): array
    {
        return [
            'instance' => $this->instance,
            'username' => $this->username,
        ];
    }

    public function __get(string $key): Stringable
    {
        return $this->{$key};
    }
}
