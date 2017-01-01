<?php 

return [
    'params' => [
    	'mod' => [
    		'post' => '文章',
            'album'=> '图集'
    	],
    	'table' => [
    		'post' => [
    			'post' => 'app\modules\cms\models\Post',
    			'post_data' => 'app\modules\cms\models\PostData'
    		],
            'album' => [
                'album' => 'app\modules\cms\models\Album',
            ]
    	]

    ]
];