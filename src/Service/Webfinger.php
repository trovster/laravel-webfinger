<?php

declare(strict_types=1);

namespace Surface\LaravelWebfinger\Service;

use ArrayIterator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use IteratorAggregate;
use Traversable;

/**
 * @property \Illuminate\Support\Stringable $instance
 * @property \Illuminate\Support\Stringable $username
 *
 * @implements \Illuminate\Contracts\Support\Arrayable<string, \Illuminate\Support\Stringable>
 * @implements \IteratorAggregate<string, \Illuminate\Support\Stringable>
 * @implements \Traversable<string, \Illuminate\Support\Stringable>
 */
class Webfinger implements Arrayable, Traversable, IteratorAggregate
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

    /** @return \ArrayIterator<string, \Illuminate\Support\Stringable> */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->toArray());
    }

    public function __get(string $key): Stringable
    {
        return $this->{$key};
    }
}
