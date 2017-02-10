<?php 

return [
    'params' =>[
        'process'  =>  [
            'user' =>  [
                //'url'   =>  '/admin/tomb/process',
                'url'   =>  '/admin/process/all',
                'text'  =>  '关联购墓人',
                'param' =>  ['tomb_id'],
                'index' => 1,
                'name'  => 'customer'
            ],
            
            'dead' =>  [
                // 'url'   =>  '/admin/dead/process',
                'url'   =>  '/admin/process/all',
                'text'  =>  '填写使用人信息',
                'param' =>  ['tomb_id'],
                'index' => 2,
                'name'  => 'dead'
            ],
            'inscription' =>  [
                //'url'   =>  '/admin/ins/process',
                'url'   =>  '/admin/process/all',
                'text'  =>  '定制碑文',
                'param' =>  ['tomb_id'],
                'index' => 3,
                'name'  => 'ins'
            ],
            'portrait' =>  [
                //'url'   =>  '/admin/portrait/process',
                'url'   =>  '/admin/process/all',
                'text'  =>  '瓷像',
                'param' =>  ['tomb_id'],
                'index' => 4,
                'name'  => 'portrait'
            ],
            'bury' =>  [
                // 'url'   =>  '/admin/bury/process',
                'url'   =>  '/admin/process/all',
                'text'  =>  '定安葬日期',
                'param' =>  ['tomb_id'],
                'index' => 5,
                'name'  => 'bury'
            ],
            'special' =>  [
                // 'url'   =>  '/admin/special/process',
                'url'   =>  '/admin/process/all',
                'text'  =>  '特殊业务',
                'param' =>  ['tomb_id'],
                'index' => 7,
                'name'  => 'special'
            ],
            'order' =>  [
                // 'url'   =>  '/admin/orderinfo/confirm',
                'url'   =>  '/admin/process/all',
                'text'  =>  '确认订单',
                'param' =>  ['order_id'],
                'index' => 8,
                'name'  => 'order'
            ],
        ],

        'dead_title' => ['父亲','母亲','祖父','祖母','丈夫','妻子','哥哥','弟弟','姐姐','妹妹','女儿','儿子','其他'],
        'bone_type'  => ['gh'=>'骨灰', 'gz'=>'骨质', 'qz'=>'青砖', 'lw'=>'灵位'],
        // 'bone_box'  => [
        //     'gz' => ['自带骨质盒','公墓购买骨质盒','红布包'],
        //     'lw' => ['公墓买红布包','自带放骨灰盒','自带红布包']
        // ],
        'bone_box'  => [
            1=>'自带骨质盒', 2=>'公墓购买骨质盒', 3=>'公墓买红布包', 4=>'自带骨灰盒',5=>'自带红布包'
        ],
        'role' => [
            'guide' => ['chaojiguanlizu_585a7860759fd','chaojiguanliyuan_585a784f9cd1a'],//导购
            'caiwu' => [''],//财务
            'agent'  => 'chaojiguanliyuan_585a784f9cd1a'//业务
        ],

        'ins' => [
            'position' =>  [
                'front' => '正面',
                'back' => '背面',
                'plate' => '盖板'
            ],
            // 'paint' => [
            //     1 => '金箔',
            //     2 => '反喷',
            //     3 => '铜粉',
            //     4 => '红漆'
            // ]
        ],

    ]

];

