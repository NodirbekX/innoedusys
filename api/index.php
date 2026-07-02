<?php

/*
 * Vercel serverless entrypoint for Laravel.
 *
 * Vercel's filesystem is read-only except for /tmp, so every path Laravel
 * writes to (framework caches, compiled views, sessions, logs, bootstrap
 * cache and storage) is redirected there before the app boots.
 *
 * App-level config (APP_KEY, APP_ENV, DB_*, MAIL_*, ...) must be set as
 * Environment Variables in the Vercel project settings.
 */

$setEnv = static function (string $key, string $value): void {
    // Only set a default if the value was not already provided by Vercel.
    if (getenv($key) === false && !isset($_ENV[$key]) && !isset($_SERVER[$key])) {
        putenv("{$key}={$value}");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
};

$tmp = '/tmp';

foreach ([
    $tmp . '/storage/framework/cache/data',
    $tmp . '/storage/framework/views',
    $tmp . '/storage/framework/sessions',
    $tmp . '/storage/app/public',
    $tmp . '/storage/logs',
    $tmp . '/bootstrap/cache',
] as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Redirect all writable paths to /tmp.
$setEnv('APP_STORAGE_PATH', $tmp . '/storage');
$setEnv('VIEW_COMPILED_PATH', $tmp . '/storage/framework/views');
$setEnv('APP_CONFIG_CACHE', $tmp . '/bootstrap/cache/config.php');
$setEnv('APP_EVENTS_CACHE', $tmp . '/bootstrap/cache/events.php');
$setEnv('APP_PACKAGES_CACHE', $tmp . '/bootstrap/cache/packages.php');
$setEnv('APP_ROUTES_CACHE', $tmp . '/bootstrap/cache/routes.php');
$setEnv('APP_SERVICES_CACHE', $tmp . '/bootstrap/cache/services.php');

// Drivers that don't require a persistent, writable filesystem. Override
// any of these in the Vercel dashboard if you have a database configured.
$setEnv('LOG_CHANNEL', 'stderr');
$setEnv('CACHE_STORE', 'array');
$setEnv('SESSION_DRIVER', 'cookie');

require __DIR__ . '/../public_html/index.php';
