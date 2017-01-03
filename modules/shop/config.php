<?php 

return [
    'params' => [
    	'image' => [
	    	'shop_attr' => [
	            'imageWater' => true,
	            'water' => true,
	            // 'savePath' => 'upload',
	            'imageMaxSize'  => '8048000',
	            'imageAllowFiles' => [".png", ".jpg", ".jpeg", ".gif", ".bmp"],
	            'imagePathFormat' => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:3}",
	            'waterMark' => 'upload/image/201602/tiny_1454577701904.jpg',
	            'textMark' => '这里是文字水印',
	            'waterPosition' => '9',//9宫格方式
	            'thumb' => [
	                'tiny' => '36*36',
	                'small' => '100*100'
	            ]
	        ],
	        'meal' => [
	            'imageWater' => true,
	            'water' => true,
	            // 'savePath' => 'upload',
	            'imageMaxSize'  => '8048000',
	            'imageAllowFiles' => [".png", ".jpg", ".jpeg", ".gif", ".bmp"],
	            'imagePathFormat' => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:3}",
	            'waterMark' => 'upload/image/201602/tiny_1454577701904.jpg',
	            'textMark' => '这里是文字水印',
	            'waterPosition' => '9',//9宫格方式
	            'thumb' => [
	                'tiny' => '36*36',
	                'small' => '100*100',
	                'middle' => '202*243'
	            ]
	        ],
	        'goods' => [
	            'imageWater' => true,
	            'water' => true,
	            // 'savePath' => 'upload',
	            'imageMaxSize'  => '8048000',
	            'imageAllowFiles' => [".png", ".jpg", ".jpeg", ".gif", ".bmp"],
	            'imagePathFormat' => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:3}",
	            'waterMark' => 'upload/image/201602/tiny_1454577701904.jpg',
	            'textMark' => '这里是文字水印',
	            'waterPosition' => '9',//9宫格方式
	            'thumb' => [
	                'tiny' => '36*36',
	                'small' => '100*100',
	                'middle' => '202*243',
	                'big' => '310*310'
	            ]
	        ]
	    ]
    ]
];