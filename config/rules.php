<?php 

return [
    
    // 'site'=> 'site/index',//site中的，就不要往module中跳了
    // 'site/<action:(.+)>'=> 'site/<action>',//site中的，就不要往module中跳了

    'admin'=> 'admin/default/index',
    'admin/default'=> 'admin/default/index',
    'admin/default/<action:(.+)>'=> 'admin/default/<action>',

    //m端
    'm/news'=> 'news/m/default/index',
    'm/news/c<id:\d+>.html'=> 'news/m/default/index',
    'm/news/<id:\d+>.html'=> 'news/m/default/view',
    'm/goods'=> 'shop/m/default/index',
    'm/goods/<id:\d+>'=> 'shop/m/default/view',
    'm/goods/<id:\d+>.html'=> 'shop/m/default/view',
    'm/user'=> 'user/m/default/index',

    'product/<id:\d+>.html' => 'home/default/product-view',
    'about/<mod:\d+>/<id:\d+>.html' => 'home/default/about-view',
    'msg/<id:\d+>.html' => 'home/default/product-msg',

    'product-msg' => 'home/default/product-msg',
    'product-msg.html' => 'home/default/product-msg',


    'products.html'=> 'home/default/product',
    'products'=> 'home/default/product',

    'abouts.html'=> 'home/default/about',
    'abouts'=> 'home/default/about',

    'contact.html'=> 'home/default/contact',
    'contact'=> 'home/default/contact',

    'resource.html'=> 'home/default/resource',
    'resource'=> 'home/default/resource',

    'home.html'=> 'home/default/index',
    'home'=> 'home/default/index',
    'home/default.html'=> 'home/default/index',
    'home/default'=> 'home/default/index',
    'home/default/<action:(.+)>.html'=> 'home/default/<action>',
    'home/default/<action:(.+)>'=> 'home/default/<action>',

    'install'=> 'install/default/index',
    'install/default'=> 'install/default/index',
    'install/default/<action:(.+)>'=> 'install/default/<action>',

    'm'=> 'm/default/index',
    'm/default'=> 'm/default/index',
    'm/default/<action:(.+)>'=> 'm/default/<action>',

    'login' => 'admin/default/login',
    'member/login' => 'member/default/login',

    '/upload/<t:(.+)>' => '/home/default/thumb',  //生成缩略图用的东西，配合nginx使用,nginx配置如下

    // location ~ \.(png|jpg|jpeg|gif)$ {
    //     #如果文件不存在,则rewrite到产生图片的脚本文件autoimg.php
    //     if (!-f $request_filename) {
    //         rewrite ^/.*$ /home/default/thumb;
    //         expires max;
    //     }
    //     #如果文件存在,则设置过期时间,关闭访问日志
    //     if ( -f $request_filename ) {
    //         expires max;
    //         access_log off;
    //     }
    // }
    
    # admin group
    'admin/<module:(.+)>/<controller:(.+)>/<action:(.+)>.html'=> '<module>/admin/<controller>/<action>',
    'admin/<module:(.+)>/<controller:(.+)>/<action:(.+)>'=> '<module>/admin/<controller>/<action>',
    'admin/<module:(.+)>/<controller:(.+)>.html'=> '<module>/admin/<controller>/index',
    'admin/<module:(.+)>/<controller:(.+)>'=> '<module>/admin/<controller>/index',
    'admin/<module:(.+)>.html'=> '<module>/admin/default/index',
    'admin/<module:(.+)>'=> '<module>/admin/default/index',

    # home group
    'home/<module:(.+)>/<controller:(.+)>/<action:(.+)>.html'=> '<module>/home/<controller>/<action>',
    'home/<module:(.+)>/<controller:(.+)>/<action:(.+)>'=> '<module>/home/<controller>/<action>',
    'home/<module:(.+)>/<controller:(.+)>.html'=> '<module>/home/<controller>/index',
    'home/<module:(.+)>/<controller:(.+)>'=> '<module>/home/<controller>/index',
    'home/<module:(.+)>.html'=> '<module>/home/default/index',
    'home/<module:(.+)>'=> '<module>/home/default/index',

    'member'=> 'member/default/index',
    'member/default'=> 'member/default/index',
    'member/default/<action:(.+)>'=> 'member/default/<action>',
    'member/<module:(.+)>/<controller:(.+)>/<action:(.+)>.html'=> '<module>/member/<controller>/<action>',
    'member/<module:(.+)>/<controller:(.+)>/<action:(.+)>'=> '<module>/member/<controller>/<action>',
    'member/<module:(.+)>/<controller:(.+)>.html'=> '<module>/member/<controller>/index',
    'member/<module:(.+)>/<controller:(.+)>'=> '<module>/member/<controller>/index',
    'member/<module:(.+)>.html'=> '<module>/member/default/index',
    'member/<module:(.+)>'=> '<module>/member/default/index',


    // 'install/<module:(.+)>'=> '<module>/install/default/index',


    # m group
    'm/<module:(.+)>/<controller:(.+)>/<action:(.+)>.html'=> '<module>/m/<controller>/<action>',
    'm/<module:(.+)>/<controller:(.+)>/<action:(.+)>'=> '<module>/m/<controller>/<action>',
    'm/<module:(.+)>/<controller:(.+)>.html'=> '<module>/m/<controller>/index',
    'm/<module:(.+)>/<controller:(.+)>'=> '<module>/m/<controller>/index',
    'm/<module:(.+)>.html'=> '<module>/m/default/index',
    'm/<module:(.+)>'=> '<module>/m/default/index',

    // '<module:(.+)>/<controller:(.+)>/<action:(.+)>.html'=> '<module>/home/<controller>/<action>',
    // '<module:(.+)>/<controller:(.+)>/<action:(.+)>'=> '<module>/home/<controller>/<action>',
    // '<module:(.+)>/<controller:(.+)>.html'=> '<module>/home/<controller>/index',
    // '<module:(.+)>/<controller:(.+)>'=> '<module>/home/<controller>/index',
    // '<module:(.+)>.html'=> '<module>/home/default/index',
    // '<module:(.+)>'=> '<module>/home/default/index',

    # mg group
    // 'mg/<module:(.+)>/<controller:(.+)>/<action:(.+)>.html'=> '<module>/mg/<controller>/<action>',
    // 'mg/<module:(.+)>/<controller:(.+)>/<action:(.+)>'=> '<module>/mg/<controller>/<action>',
    // 'mg/<module:(.+)>/<controller:(.+)>.html'=> '<module>/mg/<controller>/index',
    // 'mg/<module:(.+)>/<controller:(.+)>'=> '<module>/mg/<controller>/index',
    // 'mg/<module:(.+)>.html'=> '<module>/mg/default/index',
    // 'mg/<module:(.+)>'=> '<module>/mg/default/index',


    
];