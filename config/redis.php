<?php

$normalizeEnv = static function ($value) {
    if ($value === false) {
        return null;
    }

    $value = trim($value);
    if ($value === '') {
        return null;
    }
    $lower = strtolower($value);
    if ($lower === 'null') {
        return null;
    }
    if ($lower === 'true') {
        return true;
    }
    if ($lower === 'false') {
        return false;
    }

    return $value;
};

$env = static function (string $key, $default = null) use ($normalizeEnv) {
    $value = getenv($key);
    if ($value === false) {
        return $default;
    }

    return $normalizeEnv($value);
};

$redisUrl = $env('REDIS_URL');
$host = $env('REDIS_HOST', 'redis');
$port = $env('REDIS_PORT', 6379);
$username = $env('REDIS_USERNAME');
$password = $env('REDIS_PASSWORD');
$database = $env('REDIS_DB', 4);
$cacheDatabase = $env('REDIS_CACHE_DB', 8);

if ($redisUrl) {
    $parsed = parse_url($redisUrl);
    if ($parsed !== false) {
        if (!empty($parsed['host'])) {
            $host = $parsed['host'];
        }
        if (!empty($parsed['port'])) {
            $port = $parsed['port'];
        }
        if (array_key_exists('user', $parsed) && $parsed['user'] !== '') {
            $username = $parsed['user'];
        }
        if (array_key_exists('pass', $parsed)) {
            $password = $parsed['pass'];
        }
        if (!empty($parsed['path'])) {
            $pathDb = ltrim($parsed['path'], '/');
            if ($pathDb !== '') {
                $database = $pathDb;
            }
        }
    }
}

$port = $port !== null ? (int) $port : null;
$database = $database !== null ? (int) $database : null;
$cacheDatabase = $cacheDatabase !== null ? (int) $cacheDatabase : null;

$redisEnabled = $redisUrl !== null
    || getenv('REDIS_HOST') !== false
    || getenv('REDIS_PORT') !== false
    || getenv('REDIS_DB') !== false
    || getenv('REDIS_CACHE_DB') !== false;

return [
    'enabled' => $redisEnabled,
    'client' => $env('REDIS_CLIENT', 'predis'),
    'options' => [
        'cluster' => $env('REDIS_CLUSTER', 'wk_yii2_special_redis'),
        'prefix' => $env('REDIS_PREFIX', 'wk'),
        'persistent' => $env('REDIS_PERSISTENT', false),
    ],
    'main' => [
        'url' => $redisUrl,
        'host' => $host,
        'username' => $username,
        'password' => $password,
        'port' => $port,
        'database' => $database,
    ],
    'cache' => [
        'url' => $redisUrl,
        'host' => $host,
        'username' => $username,
        'password' => $password,
        'port' => $port,
        'database' => $cacheDatabase,
    ],
];
