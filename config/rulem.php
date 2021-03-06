<?php
/**
 * Created by PhpStorm.
 * User: wansq
 * Date: 2017/5/9
 * Time: 23:49
 */
//m端
return [
    'm/news'=> 'news/m/default/index',
    'm/news/c<id:\d+>.html'=> 'news/m/default/index',
    'm/news/<id:\d+>.html'=> 'news/m/default/view',
    'm/products'=> 'shop/m/default/index',
    'm/products/<id:\d+>'=> 'shop/m/default/index',
    'm/product/<id:\d+>'=> 'shop/m/default/view',
    'm/product/<id:\d+>.html'=> 'shop/m/default/view',
    'm/product/cart'=> 'shop/m/default/cart',
    'm/user'=> 'user/m/default/index',

    'm/order'=> 'order/m/default/index',
    'm/order/<id:\d+>'=> 'order/m/default/view',

    'm/callack' => 'wechat/m/default/callback',

    'm/memorial'=> 'memorial/m/default/index',
    'm/memorial/c<id:\d+>.html'=> 'memorial/m/default/index',
    'm/memorial/<id:\d+>.html'=> 'memorial/m/default/view',


    'm/grave'=> 'grave/m/default/index',
    'm/grave/c<id:\d+>.html'=> 'grave/m/default/index',
    'm/grave/<id:\d+>.html'=> 'grave/m/default/view',
    'm/grave/tombs.html'=> 'grave/m/default/tombs',
    'm/grave/tomb/<id:\d+>.html'=> 'grave/m/default/tomb',


    'm/article/<mid:\d+>/<cid:\d+>.html' => 'cms/m/default/index',
    'm/article/<mid:\d+>.html' => 'cms/m/default/index',
    'm/article-detail/<mid:\d+>/<id:\d+>.html' => 'cms/m/default/view',



//    'm/route'=> 'm/default/route',

    # m group
    'm/<module:(.+)>/<controller:(.+)>/<action:(.+)>.html'=> '<module>/m/<controller>/<action>',
    'm/<module:(.+)>/<controller:(.+)>.html'=> '<module>/m/<controller>/index',
    'm/<module:(.+)>.html'=> '<module>/m/default/index',

];