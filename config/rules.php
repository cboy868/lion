<?php 

$home = require(__DIR__ . '/rulehome.php');
$m = require(__DIR__ . '/rulem.php');
$member = require(__DIR__ . '/rulemember.php');
$admin = require(__DIR__ . '/ruleadmin.php');
$mobile = require(__DIR__ . '/rulemobile.php');
return array_merge([

    'admin'=> 'admin/default/index',
    'admin/default'=> 'admin/default/index',
    'admin/default/<action:(.+)>'=> 'admin/default/<action>',


    'install'=> 'install/default/index',
    'install/default'=> 'install/default/index',
    'install/default/<action:(.+)>'=> 'install/default/<action>',
    'member/login' => 'member/default/login',
    '/upload/<t:(.+)>' => '/home/default/thumb',  //生成缩略图用的东西，配合nginx使用,nginx配置如下

], $home, $m, $admin, $member,$mobile);