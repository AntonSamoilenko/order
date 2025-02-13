<?php

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
        'assetManager' => [
            'basePath' => '@webroot/assets', // Физический путь к каталогу assets
            'baseUrl' => '@web/assets',      // URL-путь к каталогу assets
            'forceCopy' => YII_ENV_DEV,      // Копировать файлы при разработке
            'bundles' => [
                // Отключаем все стандартные ассеты Yii2
                'yii\web\YiiAsset' => false,
                'yii\bootstrap4\BootstrapAsset' => false,
                'yii\bootstrap4\BootstrapPluginAsset' => false,
                'yii\widgets\ActiveFormAsset' => false, // Если используете ActiveForm
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
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
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
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
                'orders/<status:\d+>' => 'orders/list/index',
                'orders/' => 'orders/list/index',
                'orders' => 'orders/list/index',
                'orders/<status:[\w\-]+>' => 'orders/list/index',
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/modules/orders/views', // Приоритет для модуля
                ],
            ],
        ],
    ],
    'modules' => [
        'orders' => [
            'class' => 'app\modules\orders\Module',
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
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
