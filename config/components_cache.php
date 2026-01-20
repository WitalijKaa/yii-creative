<?php

return [
    'cache' => [
        'class' => 'yii\\redis\\Cache',
        'redis' => 'redisCache',
        'keyPrefix' => 'wk',
    ],
    'redis' => [
        'class' => 'yii\\redis\\Connection',
        'hostname' => 'redis',
        'port' => 6379,
        'username' => null,
        'password' => null,
        'database' => 4,
        'socketClientFlags' => STREAM_CLIENT_CONNECT,
    ],
    'redisCache' => [
        'class' => 'yii\\redis\\Connection',
        'hostname' => 'redis',
        'port' => 6379,
        'username' => null,
        'password' => null,
        'database' => 8,
        'socketClientFlags' => STREAM_CLIENT_CONNECT,
    ],
];
