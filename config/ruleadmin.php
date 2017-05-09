<?php
/**
 * Created by PhpStorm.
 * User: wansq
 * Date: 2017/5/9
 * Time: 23:50
 */

return [
# admin group
    'admin/<module:(.+)>/<controller:(.+)>/<action:(.+)>.html'=> '<module>/admin/<controller>/<action>',
    'admin/<module:(.+)>/<controller:(.+)>/<action:(.+)>'=> '<module>/admin/<controller>/<action>',
    'admin/<module:(.+)>/<controller:(.+)>.html'=> '<module>/admin/<controller>/index',
    'admin/<module:(.+)>/<controller:(.+)>'=> '<module>/admin/<controller>/index',
    'admin/<module:(.+)>.html'=> '<module>/admin/default/index',
    'admin/<module:(.+)>'=> '<module>/admin/default/index',
];