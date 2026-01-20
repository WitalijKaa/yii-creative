<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$redis = require __DIR__ . '/redis.php';

$cookieValidationKey = $params['cookieValidationKey'];
unset($params['cookieValidationKey']);

$cache = require __DIR__ . '/components_cache.php';

return array_merge([
    'request' => [
        'cookieValidationKey' => $cookieValidationKey,
    ],
    'user' => [
        'identityClass' => 'app\\models\\User',
        'enableAutoLogin' => true,
    ],
    'errorHandler' => [
        'errorAction' => 'site/error',
    ],
    'mailer' => [
        'class' => \yii\symfonymailer\Mailer::class,
        'viewPath' => '@app/mail',
        'useFileTransport' => true,
    ],
    'log' => [
        'traceLevel' => YII_DEBUG ? 3 : 0,
        'targets' => [
            [
                'class' => 'yii\\log\\FileTarget',
                'levels' => ['error', 'warning'],
            ],
        ],
    ],
    'db' => $db,
    'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'rules' => [
            'login' => 'site/login',
        ],
    ],
], $cache);