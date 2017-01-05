<?php 

return [
	'admin' => [
        'class' => 'app\modules\admin\Module',
    ],
    'home' => [
        'class' => 'app\modules\home\Module',
    ],
    'm' => [
        'class' => 'app\modules\m\Module',
    ],
    'member' => [
        'class' => 'app\modules\member\Module',
    ],
    'install' => [
        'class' => 'app\modules\install\Module',
    ],
    'wechat' => [//shop模块，把所有有关商品之类的东西放面下面
        'class' => 'app\modules\wechat\Module',
    ],
    'mod' => [//shop模块，把所有有关商品之类的东西放面下面
        'class' => 'app\modules\mod\Module',
    ],
    'user' => [
        'class' => 'app\modules\user\Module',
    ],
    'sys' => [
        'class' => 'app\modules\sys\Module',
    ],
    'test' => [ //测试用的模块
        'class' => 'app\modules\test\Module',
    ],
    'shop' => [//shop模块，把所有有关商品之类的东西放面下面
        'class' => 'app\modules\shop\Module',
    ],
    'cms' => [//shop模块，把所有有关商品之类的东西放面下面
        'class' => 'app\modules\cms\Module',
    ],
    'focus' => [
        'class' => 'app\modules\focus\Module',
    ]
];