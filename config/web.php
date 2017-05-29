<?php

$params = require(__DIR__ . '/params.php');
$mailer = require(__DIR__ . '/mailer.php');
$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'language' => "zh-CN",
    'bootstrap' => ['log'],
    'defaultRoute' => 'home',
    'modules' => require(__DIR__ . '/modules.php'),
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '85Zx_9xjD8H8Oie8QHvWGIMzPkhno16K',
        ],

        'cache' => [
            'class' => 'yii\caching\DummyCache',
        ],

        // $cache = Yii::$app->cache;
        // $cache->set('abc', 'ccc');
        // $data = $cache->get('abc');
        // if ($data === false) {

        //     $data = ...
            
        //     $cache->set('abc', 'ccc');
        // }

        'user' => [
            'identityClass' => 'app\modules\user\models\User',
            'loginUrl' => ['admin/default/login'],//'?r=admin/default/login',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => '/home/default/error',
        ],

        'mailer' => $mailer,

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require(__DIR__ . '/rules.php'),
        ],
        'authManager' => [
            'class' => 'app\modules\sys\rbac\DbManager',
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'php:Y-m-d',
            'datetimeFormat' => 'php:Y-m-d H:i',
            'timeFormat' => 'php:H:i',
            'nullDisplay' => '&nbsp;'
        ],
        'view' => [
            'theme' => [
                'basePath' => '@app/web/theme',
                'baseUrl' => '@web/theme',
            ],
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',   //使用php文件保存信息
                    'basePath' => '@app/core/messages',  //php文件保存位置
                    //'sourceLanguage' => 'en',
                    'fileMap' => [
                        // 'app' => 'app',
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'allowedIPs' => ['*'],
        'class' => 'yii\gii\Module',
        'generators'=>[
            'lionmodule'=>'app\core\gii\generators\lionmodule\Generator',

            'crud' => [// generator name
                'class' => 'yii\gii\generators\crud\Generator', // generator class
                'templates' => [//setting for out templates
                    'myCrud' => '@app/core/gii/generators/crud', // template name => path to template
                ],
            ],
        ],
    ];
}


return $config;
