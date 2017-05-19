<?php
/**
 * Created by PhpStorm.
 * User: wansq
 * Date: 2017/5/9
 * Time: 23:49
 */
//pc端
return [
    //预定


    'pre/<id:\d+>.html' => 'cms/home/message/index',
    //资讯
    'news.html' => 'news/home/default/index',
    'news/<id:\d+>.html' => 'news/home/default/index',
    'newsv/<id:\d+>.html' => 'news/home/default/view',

    //博客
    'blogs.html' => 'blog/home/default/index',


    //商品列表
    'products.html' => 'shop/home/default/index',
    //商品分类列表
    'products/<id:\d+>.html' => 'shop/home/default/index',
    //商品详情
    'product/<id:\d+>.html' => 'shop/home/default/view',

    //墓区墓位
    'grave.html' => 'grave/home/default/index',
    'grave/<id:\d+>.html' => 'grave/home/default/view',
    'tomb/<id:\d+>.html' => 'grave/home/default/tomb',

    'panel.html' => 'memorial/home/default/panel',
    'memorial.html' => 'memorial/home/default/index',
    'remote.html' => 'memorial/home/default/remote',
    'memorial/<id:\d+>.html' => 'memorial/home/default/view',

    'about.html' => 'home/default/about',
    'contact.html' => 'home/default/contact',

    'login.html' => 'home/default/login',


    # home group
//    'home/<controller:(.+)>/<action:(.+)>.html'=> 'home/<controller>/<action>',
//    'home/<controller:(.+)>.html'=> 'home/<controller>/index',
    'home.html'=> 'home/default/index',

    'home/<module:(.+)>/<controller:(.+)>/<action:(.+)>.html'=> '<module>/home/<controller>/<action>',
    'home/<module:(.+)>/<controller:(.+)>.html'=> '<module>/home/<controller>/index',
    'home/<module:(.+)>.html'=> '<module>/home/default/index',


];