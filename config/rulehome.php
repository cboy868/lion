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
    'news/<cid:\d+>.html' => 'news/home/default/index',
    'news.html' => 'news/home/default/index',
    'news-detail/<id:\d+>.html' => 'news/home/default/view',

    //图文
    'article/<mid:\d+>/<cid:\d+>.html' => 'cms/home/default/index',
    'article/<mid:\d+>.html' => 'cms/home/default/index',
    'article-detail/<mid:\d+>/<id:\d+>.html' => 'cms/home/default/view',

    //博客
    'blogs.html' => 'blog/home/default/index',


    //商品列表 商品分类列表
    'product/<id:\d+>.html' => 'shop/home/default/index',
    'product.html' => 'shop/home/default/index',
    //商品详情
    'product-detail/<id:\d+>.html' => 'shop/home/default/view',

    //墓区墓位
    'grave.html' => 'grave/home/default/index',
    'grave/<id:\d+>.html' => 'grave/home/default/view',
    'tomb/<id:\d+>.html' => 'grave/home/default/tomb',

    'panel.html' => 'memorial/home/default/panel',
    'memorial.html' => 'memorial/home/default/index',
    'remote.html' => 'memorial/home/default/remote',
    'memorial/<id:\d+>.html' => 'memorial/home/default/view',


    'about.html' => 'cms/home/about/index',
    'about-us.html' => 'cms/home/about/us',
    'about/<id:\d+>.html' => 'cms/home/about/view',

    'case.html' => 'cms/home/case/index',
    'case-us.html' => 'cms/home/case/us',
    'case/<id:\d+>.html' => 'cms/home/case/view',

    'join.html' => 'cms/home/join/index',
    'join-us.html' => 'cms/home/join/us',
    'join/<id:\d+>.html' => 'cms/home/join/view',

    'job.html' => 'cms/home/job/index',
    'job-us.html' => 'cms/home/job/us',
    'job/<id:\d+>.html' => 'cms/home/job/view',

    'team.html' => 'cms/home/team/index',
    'team-us.html' => 'cms/home/team/us',
    'team/<id:\d+>.html' => 'cms/home/team/view',

    'contact.html' => 'cms/home/contact/index',
    'contact-us.html' => 'cms/home/contact/us',
    'contact/<id:\d+>.html' => 'cms/home/contact/view',

    'service.html' => 'cms/home/service/index',
    'service-us.html' => 'cms/home/service/us',
    'service/<id:\d+>.html' => 'cms/home/service/view',

    'knowledge.html' => 'cms/home/knowledge/index',
    'knowledge-us.html' => 'cms/home/knowledge/us',
    'knowledge/<id:\d+>.html' => 'cms/home/knowledge/view',

    'grave.html' => 'cms/home/grave/index',
    'grave/<cid:\d+>.html' => 'cms/home/grave/index',
    'grave-us.html' => 'cms/home/grave/us',
    'grave-detail/<id:\d+>.html' => 'cms/home/grave/view',

    'login.html' => 'home/default/login',

    'wechat' => 'wechat/home/default/index',
    # home group
//    'home/<controller:(.+)>/<action:(.+)>.html'=> 'home/<controller>/<action>',
//    'home/<controller:(.+)>.html'=> 'home/<controller>/index',
    'home.html'=> 'home/default/index',

    'serv/<view:(.+)>.html'=> 'home/default/serv',

    'home/<module:(.+)>/<controller:(.+)>/<action:(.+)>.html'=> '<module>/home/<controller>/<action>',
    'home/<module:(.+)>/<controller:(.+)>.html'=> '<module>/home/<controller>/index',
    'home/<module:(.+)>.html'=> '<module>/home/default/index',
];