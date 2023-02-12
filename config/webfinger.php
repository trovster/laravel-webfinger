<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Webfinger Config
|--------------------------------------------------------------------------
|
| You must include your ActivityPub or Mastodon instance (URL)
| and your username.
|
*/

return [
    'instance' => env('WEBFINGER_INSTANCE', ''),
    'username' => env('WEBFINGER_USERNAME', ''),
];
