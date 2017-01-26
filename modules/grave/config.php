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



    ]

];

