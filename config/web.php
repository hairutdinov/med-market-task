<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
  'id' => 'basic',
  'basePath' => dirname(__DIR__),
  'bootstrap' => ['log'],
  'name' => 'Тестовое задание',
  'timeZone' => 'Europe/Moscow',
  'version' => '1.0',
  'charset' => 'UTF-8',
  'defaultRoute' => 'site/index',
  'layoutPath' => '@app/views/layouts',
  'layout' => 'main',
  'runtimePath' => '@app/runtime',
  'viewPath' => '@app/views',
//  'catchAll' => ['site/offline'],

  'modules' => [
    'admin' => [
      'class' => 'app\modules\admin\Module',
    ],
  ],

  'aliases' => [
    '@bower' => '@vendor/bower-asset',
    '@npm' => '@vendor/npm-asset',
  ],
  'components' => [
    'request' => [
        // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
      'cookieValidationKey' => 'pgXmONH5MOAuUDD1EfFVyJ9Vd4ZE3An8',
    ],
    'cache' => [
      'class' => 'yii\caching\FileCache',
    ],
    'user' => [
      'identityClass' => 'app\models\User',
//            'enableAutoLogin' => true,
    ],
    'errorHandler' => [
      'errorAction' => 'site/error',
    ],
    'mailer' => [
      'class' => 'yii\swiftmailer\Mailer',
        // send all mails to a file by default. You have to set
        // 'useFileTransport' to false and configure a transport
        // for the mailer to send real emails.
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
        "products/category/?<category_id:\d*>" => "product/index",
        "product/category/?<category_id:\d*>" => "product/index",
        "product/index/?<category_id:\d*>" => "product/index",
        "product/view/<id:\d*>" => "product/view",
        "admin/product/update/<id:\d*>" => "admin/product/update",
      ],
    ],
    'authManager' => [
      'class' => 'yii\rbac\DbManager',
    ],
  ],
  'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
      'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
      'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
