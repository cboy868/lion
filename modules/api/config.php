<?php
use yii\helpers\Url;

return [
    'params' =>[
        'debug'  => true,
        'log' => [
            'level'      => 'trace',
            'permission' => 0777,
            'file'       => '/tmp/easywechat.log',
        ],
        'wx' => [
            'appid' => 'wxf2831524143015af',
            'appsecret' => 'fa7aec57b599c0e1155b4ba19857a8f5',
            'token' => '7JPN8xArTFbvBgIjHXaDZdnwf3tQeY2c',
        ],
        'miniProgram'=> [
            'appid' => 'wxddc8ada25ff73f9e',
            'appsecret' => 'f29ab7ad6001d56bc6b7f9e991afb3e5',
        ],
        'payment' => [
            'merchant_id'        => '1487057712',
            'key'                => 'ba8c8eef2ce4a75eb264485baabbf6ae',
            'cert_path'     => Yii::getAlias('@app/web/static/cert/apiclient_cert.pem'),//'path/to/your/cert.pem', // XXX: 绝对路径！！！！
            'key_path'      => Yii::getAlias('@app/web/static/cert/apiclient_key.pem'),//'path/to/your/key',
            'notify_url'    => 'http://lion.ibagou.com/wechat/home/order/notify'
        ],

    ]
];
