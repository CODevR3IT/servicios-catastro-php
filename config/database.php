<?php
return [
    'default' => 'oracle',
    'connections' => [
        'oracle' => [
            'driver'        => 'oracle',
            'tns'           => env('DB_TNS', ''),
            'host'          => env('DB_HOST', ''),
            'port'          => env('DB_PORT', '1521'),
            'database'      => env('DB_DATABASE', ''),
            'username'      => env('DB_USERNAME', ''),
            'password'      => env('DB_PASSWORD', ''),
            'charset'       => env('DB_CHARSET', 'AL32UTF8'),
            'prefix'        => env('DB_PREFIX', ''),
            'prefix_schema' => env('DB_SCHEMA_PREFIX', ''),
            'edition'       => env('DB_EDITION', 'ora$base'),
        ],
        'ws' => [
            'driver'        => 'oracle',
            'tns'           => env('DB_TNS_PRECAT', ''),
            'host'          => env('DB_HOST_PRECAT', ''),
            'port'          => env('DB_PORT', '1521'),
            'database'      => env('DB_DATABASE_PRECAT', ''),
            'username'      => env('DB_USERNAME_PRECAT', ''),
            'password'      => env('DB_PASSWORD_PRECAT', ''),
            'charset'       => env('DB_CHARSET', 'AL32UTF8'),
            'prefix'        => env('DB_PREFIX', ''),
            'prefix_schema' => env('DB_SCHEMA_PREFIX', ''),
            'edition'       => env('DB_EDITION', 'ora$base'),
        ],
    ]
        ];