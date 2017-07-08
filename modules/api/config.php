<?php 

return [
    'params' =>[],

    'components' => [
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
            'identityClass' => 'api\common\models\User',
            // 'loginUrl' => ['admin/default/login'],//'?r=admin/default/login',
            'enableAutoLogin' => true,
            'enableSession' => false
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            // 'enableStrictParsing' =>true,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v1/news',
                        'v1/order',
                        'v1/goods',
                        'v1/post',
                        'v1/user',
                        'v1/memorial'
                    ]
                ]
            ]
        ]

    ]
];

