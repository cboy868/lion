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
            'imageWater' => true,
    		// 'savePath' => 'upload',
    		'imageMaxSize'  => '2048000',
    		'imageAllowFiles' => [".png", ".jpg", ".jpeg", ".gif", ".bmp"],
    		'imagePathFormat' => "/upload/image/{yyyy}{mm}/{time}{rand:3}",
    		'waterPosition' => '9',//9宫格方式
            'waterMark' => 'upload/image/201602/tiny_1454577701904.jpg',
            'textMark' => '这里是文字水印'
    	],

        'avatar' => [
            'imageWater' => true,
            'db' => true,//是否存入数据库
            // 'savePath' => 'upload',
            'imageMaxSize'  => '2048000',
            'imageAllowFiles' => [".png", ".jpg", ".jpeg", ".gif", ".bmp"],
            'imagePathFormat' => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:3}",
            'waterMark' => 'upload/image/201602/tiny_1454577701904.jpg',
            'textMark' => '这里是文字水印',
            'waterPosition' => '9',//9宫格方式
            'thumb' => [
                'tiny' => '45*45',
                'small'=>'100*100',
            ]
        ],
    	'post' => [
            'imageWater' => true,
            'db' => true,//是否存入数据库
    		// 'savePath' => 'upload',
    		'imageMaxSize'  => '2048000',
    		'imageAllowFiles' => [".png", ".jpg", ".jpeg", ".gif", ".bmp"],
    		'imagePathFormat' => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:3}",
            'waterMark' => 'upload/image/201602/tiny_1454577701904.jpg',
            'textMark' => '这里是文字水印',
    		'waterPosition' => '9',//9宫格方式
    		'thumb' => [
                'tiny' => '100*100',
                'small'=>'295*174',
    			'big'=>'1400*800', 
    		]
    	],
        'shop_category' => [
            'imageWater' => true,
            'db' => true,//是否存入数据库
            // 'savePath' => 'upload',
            'imageMaxSize'  => '2048000',
            'imageAllowFiles' => [".png", ".jpg", ".jpeg", ".gif", ".bmp"],
            'imagePathFormat' => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:3}",
            'waterMark' => 'upload/image/201602/tiny_1454577701904.jpg',
            'textMark' => '这里是文字水印',
            'waterPosition' => '9',//9宫格方式
            'thumb' => [
                'tiny' => '100*100',
            ]
        ],
        'foods_category' => [
            'imageWater' => true,
            'db' => true,//是否存入数据库
            // 'savePath' => 'upload',
            'imageMaxSize'  => '2048000',
            'imageAllowFiles' => [".png", ".jpg", ".jpeg", ".gif", ".bmp"],
            'imagePathFormat' => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:3}",
            'waterMark' => 'upload/image/201602/tiny_1454577701904.jpg',
            'textMark' => '这里是文字水印',
            'waterPosition' => '9',//9宫格方式
            'thumb' => [
                'tiny' => '100*100',
            ]
        ],
        'foods' => [
            'imageWater' => true,
            'db' => true,//是否存入数据库
            // 'savePath' => 'upload',
            'imageMaxSize'  => '2048000',
            'imageAllowFiles' => [".png", ".jpg", ".jpeg", ".gif", ".bmp"],
            'imagePathFormat' => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:3}",
            'waterMark' => 'upload/image/201602/tiny_1454577701904.jpg',
            'textMark' => '这里是文字水印',
            'waterPosition' => '9',//9宫格方式
            'thumb' => [
                'tiny' => '36*36',
            ]
        ],
        'shop_goods_tpl' => [
            'imageWater' => true,
            'water' => true,
            'db' => true,//是否存入数据库
            // 'savePath' => 'upload',
            'imageMaxSize'  => '2048000',
            'imageAllowFiles' => [".png", ".jpg", ".jpeg", ".gif", ".bmp"],
            'imagePathFormat' => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:3}",
            'waterMark' => 'upload/image/201602/tiny_1454577701904.jpg',
            'textMark' => '这里是文字水印',
            'waterPosition' => '9',//9宫格方式
            'thumb' => [
                'tiny' => '36*36',
                'small' => '100*100'
            ]
        ]

    ],
];

return array_merge($setting, $params);








