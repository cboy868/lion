<?php
/**
 * Created by PhpStorm.
 * User: wansq
 * Date: 2017/5/10
 * Time: 0:07
 */

return [



//
//    'blog/create.html' => 'blog/member/default/create',
//    'blog/update/<id:\d+>.html' => 'blog/member/default/update',
//    'blog.html' => 'blog/member/default/index',
//    'blog/<id:\d+>.html' => 'blog/member/default/view',
//
//    'album.html' => 'blog/member/album/index',
//    'album/<id:\d+>.html' => 'blog/member/album/view',
//
//    'video.html' => 'blog/member/video/index',
//    'video/<id:\d+>.html' => 'blog/member/video/view',
//
//
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