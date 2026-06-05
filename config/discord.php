<?php

return [
    'webhooks' => [
        'purchases'  => env('DISCORD_WEBHOOK_PURCHASES'),
        'registers'  => env('DISCORD_WEBHOOK_REGISTERS'),
        'carts'      => env('DISCORD_WEBHOOK_CARTS'),
        'reports'    => env('DISCORD_WEBHOOK_REPORTS'),
    ],
    'enabled' => env('DISCORD_NOTIFICATIONS_ENABLED', true),
    'username' => env('DISCORD_BOT_USERNAME', 'MyApp Bot'),
    'avatar_url' => env('DISCORD_BOT_AVATAR', null),
];