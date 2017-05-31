<?php 

return [
    'params' => [
    	'set_modules' => [
    		'system'=>'系统设置',
		    'upload'=>'上传设置',
		    'seo'=>'seo设置',
		    'email'=>'邮件设置',
    	],
        'panels'  =>  [
            'yw' =>  [ 'name'=>'业务操作', 'icon'=>'fa fa-cubes'],
            'data' =>  [ 'name'=>'数据记录', 'icon'=>'fa fa-list-alt'],
            'cms' =>  [ 'name'=>'门户操作', 'icon'=>'fa fa-home'],
            'sys' =>  [ 'name'=>'系统管理', 'icon'=>'fa fa-gears'],
            'analysis' =>  [ 'name'=>'数据统计', 'icon'=>'fa fa-bar-chart'],
        ]
    ]
];