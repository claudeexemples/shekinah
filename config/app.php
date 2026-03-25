<?php

return [
    'name'     => env('APP_NAME', 'Shekinah — Gestão Eclesiástica'),
    'env'      => env('APP_ENV', 'production'),
    'debug'    => (bool) env('APP_DEBUG', false),
    'url'      => env('APP_URL', 'http://localhost'),
    'timezone' => env('APP_TIMEZONE', 'Africa/Luanda'),
    'locale'   => env('APP_LOCALE', 'pt_AO'),
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'pt'),
    'faker_locale'    => env('APP_FAKER_LOCALE', 'pt_BR'),
    'cipher'   => 'AES-256-CBC',
    'key'      => env('APP_KEY'),
    'previous_keys' => [...array_filter(explode(',', env('APP_PREVIOUS_KEYS', '')))],
    'maintenance' => ['driver' => 'file'],
    'providers' => Illuminate\Support\ServiceProvider::defaultProviders()->toArray(),
    'aliases'  => Illuminate\Foundation\AliasLoader::getInstance()->getAliases(),
];
