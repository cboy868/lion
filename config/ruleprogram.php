<?php
/**
 * Created by PhpStorm.
 * User: wansq
 * Date: 2017/5/9
 * Time: 23:49
 */
//m端
return [
    # m group
    'program/<module:(.+)>/<controller:(.+)>/<action:(.+)>.html'=> '<module>/program/<controller>/<action>',
    'program/<module:(.+)>/<controller:(.+)>.html'=> '<module>/program/<controller>/index',
    'program/<module:(.+)>.html'=> '<module>/program/default/index',

];