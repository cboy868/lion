<?php
use yii\helpers\Url;

return [
    'params' =>[
        'subject_cate' => [
            'jieri' => '商品节日专题',
            'gongsi'=> '公司专题',
            'zixun' => '资讯专题'
        ],
        'nav_module' => [
            [
                'name' => 'default',
                'title' => '首页',
                'url' => '/home/default/index'
            ],
            [
                'name' => 'about',
                'title' => '关于我们',
                'url' => '/home/default/about'
            ],
            [
                'name' => 'contact',
                'title' => '联系',
                'url' => '/home/default/contact'
            ],
            [
                'name' => 'news',
                'title' => '新闻资讯',
                'url' => '/news/home/default/index'
            ],
            [
                'name' => 'grave',
                'title' => '墓区产品',
                'url' => '/grave/home/default/index'
            ],
            [
                'name' => 'blog',
                'title' => '博客',
                'url' => '/blog/home/default/index'
            ],
            [
                'name' => 'shop',
                'title' => '商品列表',
                'url' => '/shop/home/default/index'
            ],
            [
                'name' => 'panel',
                'title' => '祭祀广场',
                'url' => '/memorial/home/default/panel'
            ],
            [
                'name' => 'memorial',
                'title' => '纪念馆',
                'url' => '/memorial/home/default/index'
            ]

        ]

    ]

];

