<?php
return [

    'default' => 'mysql',

    'connections' => [
        'users' => [
            'driver'    => env('VELMIE_WALLET_USERS_DB_DRIV', 'mysql'),
            'host'      => env('VELMIE_WALLET_USERS_DB_HOST') . ':' . env('VELMIE_WALLET_USERS_DB_PORT', '3306'),
            'database'  => env('VELMIE_WALLET_USERS_DB_NAME', 'users'),
            'username'  => env('VELMIE_WALLET_USERS_DB_USER'),
            'password'  => env('VELMIE_WALLET_USERS_DB_PASS'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
        'currencies' => [
            'driver'    => env('VELMIE_WALLET_CURRENCIES_DB_DRIV', 'mysql'),
            'host'      => env('VELMIE_WALLET_CURRENCIES_DB_HOST') . ':' . env('VELMIE_WALLET_CURRENCIES_DB_PORT', '3306'),
            'database'  => env('VELMIE_WALLET_CURRENCIES_DB_NAME', 'currencies'),
            'username'  => env('VELMIE_WALLET_CURRENCIES_DB_USER'),
            'password'  => env('VELMIE_WALLET_CURRENCIES_DB_PASS'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
        'accounts' => [
            'driver'    => env('VELMIE_WALLET_ACCOUNTS_DB_DRIV', 'mysql'),
            'host'      => env('VELMIE_WALLET_ACCOUNTS_DB_HOST') . ':' . env('VELMIE_WALLET_ACCOUNTS_DB_PORT', '3306'),
            'database'  => env('VELMIE_WALLET_ACCOUNTS_DB_NAME', 'accounts'),
            'username'  => env('VELMIE_WALLET_ACCOUNTS_DB_USER'),
            'password'  => env('VELMIE_WALLET_ACCOUNTS_DB_PASS'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
        'settings' => [
            'driver' => env('VELMIE_WALLET_SETTINGS_DB_DRIV', 'mysql'),
            'host' => env('VELMIE_WALLET_SETTINGS_DB_HOST') . ':' . env('VELMIE_WALLET_SETTINGS_DB_PORT', '3306'),
            'database' => env('VELMIE_WALLET_SETTINGS_DB_NAME', 'settings'),
            'username' => env('VELMIE_WALLET_SETTINGS_DB_USER'),
            'password' => env('VELMIE_WALLET_SETTINGS_DB_PASS'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
    ]
];