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
    'blog' => [
        //写博客时的初始状态 0待审核 1审核成功
        'blogInitStatus' => 1,
        'missInitStatus' => 1,
        'archiveInitStatus' => 1
    ],
    'wechat' => [
        'wx' => [
            'appid' => 'wxa49d94dde698d291',
            'appsecret' => 'db9f2d31ee80a622568d7f6eab3649c8',
            'token' => 'lion',
        ],
        'payment' => [
            'merchant_id'   => '1487057712',
            'key'           => '886296',
//            'cert_path'     => Yii::getAlias('@app/web/static/cert/apiclient_cert.pem'),//'path/to/your/cert.pem', // XXX: 绝对路径！！！！
//            'key_path'      => Yii::getAlias('@app/web/static/cert/apiclient_key.pem'),//'path/to/your/key',      // XXX: 绝对路径！！！！
            'notify_url'    => '默认的订单回调地址',       // 你也可以在下单时单独设置来想覆盖它
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








