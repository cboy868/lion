<?php
$params = require(__DIR__ . '/params.php');
$config = [
    'id' => 'app-api',
    'basePath' => dirname(dirname(__DIR__)),
    'bootstrap' => ['log'],
    'language' => "zh-CN",
    // 'controllerNamespace' => 'api\modules\v1\controllers',
    'modules' => [
        'api' => [
            'class' => 'app\modules\api\Module',
        ],
        'grave' => [
            'class' => 'app\modules\grave\Module',
        ],
        'wechat' => [
            'class' => 'app\modules\wechat\Module',
        ],
        'analysis' => [
            'class' => 'app\modules\analysis\Module',
        ],
    ],
    'components' => [
        'db' => require(__DIR__ . '/../db.php'),
        'request' => [
            'csrfParam' => '_csrf-api',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'DZyQuOOC0Jv06edmgptsZsFda4tq2MBQ',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'text/json' => 'yii\web\JsonParser',

            ]
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-api',
        ],
        'user' => [
            'identityClass' => 'app\modules\user\models\User',
            'enableAutoLogin' => true,
            'enableSession' => false
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'view' => [
            'theme' => [
                'basePath' => '@app/web/theme',
                'baseUrl' => '@web/theme',
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            // 'enableStrictParsing' =>true,
            'rules' => [

                //如果加了以下两行 delete等动词就不能用了
//                'v1/<controller:(.+)>/<id:\d+>' => '/api/v1/<controller>/view',
//                'v1/<controller:(.+)>' => '/api/v1/<controller>',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'api/v1/news',
                        'api/v1/order',
                        'api/v1/goods',
                        'api/v1/post',
                        'api/v1/user',
                        'api/v1/grave',
                        'api/v1/tomb',
                        'api/v1/memorial',
                        'api/v1/wechat-user',
                        'api/v1/wechat-pro-user',
                        'api/v1/free-dead'
                    ],
                ],
                # m group
                'm/<module:(.+)>/<controller:(.+)>/<action:(.+)>.html'=> '<module>/m/<controller>/<action>',
                'm/<module:(.+)>/<controller:(.+)>.html'=> '<module>/m/<controller>/index',
                'm/<module:(.+)>.html'=> '<module>/m/default/index',
            ],
        ],

    ],
    'params' => $params,
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;