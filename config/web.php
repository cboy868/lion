<?php

$params = require(__DIR__ . '/params.php');

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

        'mailer' => [  
           'class' => 'yii\swiftmailer\Mailer',  
            'useFileTransport' =>false,//这句一定有，false发送邮件，true只是生成邮件在runtime文件夹下，不发邮件
            'htmlLayout' => '@app/core/views/mail/html.php',
            'transport' => [  
               'class' => 'Swift_SmtpTransport',  
               'host' => 'smtp.163.com',  //每种邮箱的host配置不一样
               'username' => '18501179465@163.com',  
               'password' => 'zxn252',
               'port' => '25',  
               'encryption' => 'tls',  
            ],   
            'messageConfig'=>[  
               'charset'=>'UTF-8',  
               'from'=>['18501179465@163.com'=>'admin']  
            ],  
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
            'datetimeFormat' => 'php:Y-m-d H:i:s',
            'timeFormat' => 'php:H:i:s',
        ],
        'view' => [
            'theme' => [
                'basePath' => '@app/web/theme',
                'baseUrl' => '@web/theme',
                'pathMap' => [
                    '@app/views' => '@app/web/theme/site',
                    '@app/modules/home/views/layouts' => '@app/web/theme/site/layouts', // <-- !!!
                    '@app/modules/home/views' => '@app/web/theme/site' // <-- !!!
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
