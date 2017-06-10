<?php
use app\core\helpers\Url;
return [
    'params' =>[
        'debug'  => true,
        'log' => [
            'level'      => 'trace',
            'permission' => 0777,
            'file'       => '/tmp/easywechat.log',
        ],
        'oauth' => [
            'scopes'   => ['snsapi_userinfo'],
            'callback' => Url::toRoute(['/wechat/m/default/callback']),
        ],
        'payment' => [
            'merchant_id'        => 'your-mch-id',
            'key'                => 'key-for-signature',
            'cert_path'          => 'path/to/your/cert.pem', // XXX: 绝对路径！！！！
            'key_path'           => 'path/to/your/key',      // XXX: 绝对路径！！！！
            // 'device_info'     => '013467007045764',
            // 'sub_app_id'      => '',
            // 'sub_merchant_id' => '',
            // ...
        ],

        'menu' => [
            'language' => [
                0=>'不限',
                1=>'简体中文',
                2=>'繁体中文TW',
                3=>'繁体中文HK',
                4=>'英文',
                5=>'印尼',
                6=>'马来',
                7=>'西班牙',
                8=>'韩国',
                9=>'意大利',
                10=>'日本',
                11=>'波兰',
                12=>'葡萄牙',
                13=>'俄国',
                14=>'泰文',
                15=>'越南',
                16=>'阿拉伯语',
                17=>'北印度',
                18=>'希伯来',
                19=>'土耳其',
                20=>'德语',
                21=>'法语'
            ],
            'platform' => [
                0=>'不限',
                1=>'IOS',
                2=>'Android',
                3=>'Others'
            ]
        ],
        'urls'=>[//微信菜单地址时，可使用的url;
            Url::toRoute('/m/default/index') => '首页',
            Url::toRoute('/m/default/route') => '一键导航',
            Url::toRoute('/shop/m/default/index') => '商品购买',
        ],
        'screen_url'     => 'http://screen.ibagou.com:8080',
    ]
];
