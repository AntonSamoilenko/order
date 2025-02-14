<?php

use yii\symfonymailer\Mailer;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'assetManager' => [],
        'request' => [
            'cookieValidationKey' => '9aFM5eQImHNng3RErw8x0VIYnCErxaRX',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => Mailer::class,
            'viewPath' => '@app/mail',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'orders/<status:\w+>' => 'orders/list/index',
                'orders/' => 'orders/list/index',
                'orders' => 'orders/list/index',
            ],
        ],
    ],
    'modules' => [
        'orders' => [
            'class' => 'app\modules\orders\Module',
            'layout' => 'main.php',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    //todo исправить это
    // configuration adjustments for 'dev' environment
//    $config['bootstrap'][] = 'debug';
//    $config['modules']['debug'] = [
//        'class' => 'yii\debug\Module',
//        // uncomment the following to add your IP if you are not connecting from localhost.
////        'allowedIPs' => ['127.0.0.1', '::1'],
////        'panels' => [
////            'db' => [
////                'class' => 'yii\debug\panels\DbPanel',
////                'excludeActions' => ['orders/default/export-csv'], // Исключаем экшен export-csv
////            ],
////        ],
//    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
