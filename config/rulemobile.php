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
    'mobile/<module:(.+)>/<controller:(.+)>/<action:(.+)>.html'=> '<module>/mobile/<controller>/<action>',
    'mobile/<module:(.+)>/<controller:(.+)>.html'=> '<module>/mobile/<controller>/index',
    'mobile/<module:(.+)>.html'=> '<module>/mobile/default/index',

];