<?php

declare(strict_types=1);

namespace Surface\LaravelWebfinger\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Stringable;

class Webfinger extends JsonResource
{
    /** @var string|null $wrap */
    public static $wrap = null;

    public function __construct(protected Stringable $instance, protected Stringable $username)
    {
        parent::__construct(null);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array<string, array<int, array<string, string>|string>|string>
     */
    public function toArray($request): array
    {
        return [
            'subject' => $this->subject($request),
            'aliases' => $this->aliases($request),
            'links' => $this->links($request),
        ];
    }

    public function subject(Request $request): string
    {
        $instanceName = $this->instance->ltrim('https://')->rtrim('/');

        return "acct:{$this->username}@{$instanceName}";
    }

    /** @return array<int, string> */
    public function aliases(Request $request): array
    {
        return [
            "{$this->instance}@{$this->username}",
            "{$this->instance}users/{$this->username}",
        ];
    }

    /** @return array<int, array<string, string>> */
    public function links(Request $request): array
    {
        return [
            [
                'rel' => 'http://webfinger.net/rel/profile-page',
                'type' => 'text/html',
                'href' => "{$this->instance}@{$this->username}",
            ],
            [
                'rel' => 'self',
                'type' => 'application/activity+json',
                'href' => "{$this->instance}users/{$this->username}",
            ],
            [
                'rel' => 'http://ostatus.org/schema/1.0/subscribe',
                'template' => "{$this->instance}authorize_interaction?uri={uri}",
            ],
        ];
    }
}
