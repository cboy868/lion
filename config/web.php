<?php

$params = require(__DIR__ . '/params.php');
$mailer = require(__DIR__ . '/mailer.php');
$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'sourceLanguage' => 'en-US',
    'language' => "zh-CN",
    'timeZone'=>'Asia/Chongqing',
    'bootstrap' => ['log'],
    'defaultRoute' => 'home',
    'vendorPath' => __DIR__ . '/../../framework/vendor',
    'modules' => require(__DIR__ . '/modules.php'),
    'on beforeRequest' => function($event) {
        \yii\base\Event::on(\yii\db\BaseActiveRecord::className(), \yii\db\BaseActiveRecord::EVENT_AFTER_INSERT, ['app\core\base\OpLog', 'write']);
        \yii\base\Event::on(\yii\db\BaseActiveRecord::className(), \yii\db\BaseActiveRecord::EVENT_AFTER_UPDATE, ['app\core\base\OpLog', 'write']);
        \yii\base\Event::on(\yii\db\BaseActiveRecord::className(), \yii\db\BaseActiveRecord::EVENT_BEFORE_DELETE, ['app\core\base\OpLog', 'write']);
    },
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '85Zx_9xjD8H8Oie8QHvWGIMzPkhno16K',
        ],

        'cache' => [
            'class' => 'yii\caching\FileCache',
            'keyPrefix' => 'lion_app'
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
            'flushInterval' => 100,   // default is 1000
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logVars' => ['_SERVER'],
                    'exportInterval' => 1,
                ],
                [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error'],
                    'logVars' => ['_SERVER'],
                    'exportInterval' => 1,
                ],
                [
                    'class' => 'yii\log\EmailTarget',
                    'levels' => ['error'],
                    'categories' => ['yii\db\*'],
                    'message' => [
                        'from' => ['cboy868@163.com'],
                        'to' => ['cboy868@163.com'],
                        'subject' => 'Database errors at lion.com',
                    ],
                    'logVars' => [],
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
            'cache' => [
                'class'=>'yii\caching\FileCache'
            ]
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
                    'class' => 'yii\i18n\DbMessageSource',   //使用数据库保存信息
                    'sourceMessageTable' => '{{%source_message}}',
                    'messageTable' => '{{%target_message}}'
//                    'basePath' => '@app/core/messages',  //php文件保存位置
//                    'sourceLanguage' => 'en-US',
//                    'fileMap' => [
//                        // 'app' => 'app',
//                    ],
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
