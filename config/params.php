<?php

$setting = require(__DIR__ . '/setting.php');
$thumb = require(__DIR__ . '/thumb.php');
$goods = require(__DIR__ . '/goods.php');

$params = [
    'version' =>'20170620 1.0',
    'adminEmail' => 'cboy868@163.com',
    'supportEmail' => 'info@zhuo-xun.com',
    'user.passwordResetTokenExpire' => 3600,
    'i18n' => [
        'flag'=>false,
        'main' => 'zh-CN',
        'languages' => [
            'zh-CN' => '中文',
            'en-US' => '英文(English)',
            'ru-RU' => 'ru'
        ]
    ],
    'wechat' => [
        'wx' => [
            'appid' => 'wxa49d94dde698d291',
            'appsecret' => 'db9f2d31ee80a622568d7f6eab3649c8',
            'token' => 'lion',
        ]
    ],
    'sms' => [
        'id' => 'cboy868',
        'pwd' => 'wsq850531',
    ],
    'file' => [
        'common' => [
            'fileMaxSize'  => '8048000',
            'fileAllowFiles' => [".xlsx",".xls"],
            'filePathFormat' => "/upload/file/{yyyy}{mm}/{time}{rand:3}"
        ]
    ],
    'image' => [
    	'common' => [
            'water' => 1,
    		'imageMaxSize'  => '8048000',
    		'imageAllowFiles' => [".png", ".jpg", ".jpeg", ".gif", ".bmp"],
    		'imagePathFormat' => "/upload/image/{yyyy}{mm}/{time}{rand:3}",
            'min_width' => 100,
            'min_height' => 100
    	],

//        'imgconfig' => [
//            'water' => false,
//            'water_pos' => '-1',
//            // 'savePath' => 'upload',
//        ],
//
//        'shop_attr' => [
//            'water' => false,
//            'thumb' => [
//                'tiny' => '36x36',
//                'small' => '100x100'
//            ]
//        ],
    ],

];

return \yii\helpers\ArrayHelper::merge($setting, $params, $thumb, $goods);








