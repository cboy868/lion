<?php
/**
 * Created by PhpStorm.
 * User: wansq
 * Date: 2017/5/10
 * Time: 0:07
 */

return [

    'blog/create.html' => 'blog/member/default/create',
    'blog/update/<id:\d+>.html' => 'blog/member/default/update',

    'member'=> 'member/default/index',
    'member/default'=> 'member/default/index',
    'member/default/<action:(.+)>'=> 'member/default/<action>',
    'member/<module:(.+)>/<controller:(.+)>/<action:(.+)>.html'=> '<module>/member/<controller>/<action>',
    'member/<module:(.+)>/<controller:(.+)>/<action:(.+)>'=> '<module>/member/<controller>/<action>',
    'member/<module:(.+)>/<controller:(.+)>.html'=> '<module>/member/<controller>/index',
    'member/<module:(.+)>/<controller:(.+)>'=> '<module>/member/<controller>/index',
    'member/<module:(.+)>.html'=> '<module>/member/default/index',
    'member/<module:(.+)>'=> '<module>/member/default/index',
];