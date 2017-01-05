<?php

$setting = require(__DIR__ . '/setting.php');
$thumb = require(__DIR__ . '/thumb.php');

$params = [
    'adminEmail' => 'cboy868@163.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'wechat' => [
        'wx' => [
            'appid' => 'wxa49d94dde698d291',
            'appsecret' => 'db9f2d31ee80a622568d7f6eab3649c8',
            'token' => 'lion',
            
        ]
    ],

    'image' => [
    	'common' => [
            'water' => 1,
    		'imageMaxSize'  => '8048000',
    		'imageAllowFiles' => [".png", ".jpg", ".jpeg", ".gif", ".bmp"],
    		'imagePathFormat' => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:3}",
    	],

        'imgconfig' => [
            'water' => false,
            'water_pos' => '-1',
            // 'savePath' => 'upload',
        ],

        'shop_attr' => [
            'water' => false,
            'thumb' => [
                'tiny' => '36x36',
                'small' => '100x100'
            ]
        ],
    ],
];

return \yii\helpers\ArrayHelper::merge($setting, $params, $thumb);








