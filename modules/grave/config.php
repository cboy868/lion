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

        'goods' => [
            'cate' => [
                'ins' => 6,
                'portrait' => 5
            ],

            'id' => [
                //
            ]
        ],
        'car' => [
            'type' => [
                1 => ['name'=>'迎灵车','max'=>6,'num'=>5],//车名  最大载人 车数量
                2 => ['name'=>'风行车','max'=>6,'num'=>5],
                3 => ['name'=>'自驾车','max'=>6,'num'=>5]
            ]
        ],

        'ins' => [
            'goods_attr' => [
                'id'=>8,
                'shape' => [
                    '19' => 'h',
                    '20' => 'v'
                ]
            ],
            'position' =>  [
                'front' => '正面',
                'back' => '背面',
                // 'plate' => '盖板'
            ],
            'inscribe' => [
                '儿子'     =>  '孝子率全家叩立',
                '女儿'     =>  '孝女率全家叩立',
                '儿子女儿'  =>  '孝子女率全家叩立',
                '儿子儿媳'  =>  '孝子、媳率全家叩立',
                '女儿女婿'  =>  '孝女、婿率全家叩立'
            ],
            'ins_title' => [
                'v' => [
                    '父亲'    =>  '父',
                    '母亲'    =>  '母',
                    '祖父'    =>  '父',
                    '祖母'    =>  '母',
                    '丈夫'    =>  '夫',
                    '妻子'    =>  '妻',
                    '哥哥'    =>  '哥',
                    '嫂子'    =>  '嫂',
                    '弟弟'    =>  '弟',
                    '弟媳'    =>  '媳',
                    '姐姐'    =>  '姐',
                    '姐夫'    =>  '夫',
                    '妹妹'    =>  '妹',
                    '妹夫'    =>  '夫',
                    '女儿'    =>  '女',
                    '儿子'    =>  '儿',
                    '侄子'    =>  '侄子',
                    '侄女'    =>  '侄女',
                    '姑姑'    =>  '姑',
                    '姑父'    =>  '姑父',
                    '舅舅'    =>  '舅',
                    '舅妈'    =>  '舅妈',
                    '阿姨'    =>  '姨',
                    '叔叔'    =>  '叔',
                ],
                'h' => [
                    '父亲'    =>  '父',
                    '母亲'    =>  '母',
                    '祖父'    =>  '父',
                    '祖母'    =>  '母',
                    '丈夫'    =>  '夫',
                    '妻子'    =>  '妻',
                    '哥哥'    =>  '胞兄',
                    '弟弟'    =>  '胞弟',
                    '姐姐'    =>  '胞姐',
                    '妹妹'    =>  '胞妹',
                    '嫂子'    =>  '嫂子',
                    '弟媳'    =>  '弟媳',
                    '姐夫'    =>  '姐夫',
                    '妹夫'    =>  '妹夫',
                    '女儿'    =>  '女',
                    '儿子'    =>  '儿',
                    '侄子'    =>  '侄子',
                    '侄女'    =>  '侄女',
                    '姑姑'    =>  '姑',
                    '姑父'    =>  '姑父',
                    '舅舅'    =>  '舅',
                    '舅妈'    =>  '舅妈',
                    '阿姨'    =>  '姨',
                    '叔叔'    =>  '叔',
                ]
            ],
            'back_word' => [
                "福荫后代",
                "永远怀念",
                "德留人间,福荫后代",
                "父恩如山,母爱似海",
                "养育之恩,世代铭记",
                "积德耀宗,聚福泽后",
                "难舍的亲情,永远的怀念"
            ],
            'paint' => [
                1 => '金箔',
                2 => '铜粉',
                3 => '红漆',
                4 => '反喷'
            ],
            'font' => [
                '0' =>  [
                    "name" => "华文新魏", 
                    "s" => "./static/font/ins/STXINWEI.TTF",
                    "t" => "./static/font/ins/FZWeiBei-S03T.ttf" 
                ],
                '1' =>  [
                    "name" => "行楷",
                    "s" => "./static/font/ins/FZXingKai-S04S.ttf",
                    't' => "./static/font/ins/FZXingKai-S04T.ttf"
                ],
                '2' =>  [
                    "name" => "方正隶书", 
                    "s" => "./static/font/ins/FZLiShu-S01S.ttf",
                    "t" => "./static/font/ins/FZLiShu-S01T.ttf" 
                ],
                '3' =>  [
                    "name" => "宋体", 
                    "s" => "./static/font/ins/simsun.ttc",
                    "t" => "./static/font/ins/simsun.ttc" 
                ],
                '4' => [
                    "name" => "楷体",
                    "s" => "./static/font/ins/JDJK.TTF",
                    "t" => "./static/font/ins/JDJK.TTF"
                ]
            ]
            // 'paint' => [
            //     1 => '金箔',
            //     2 => '反喷',
            //     3 => '铜粉',
            //     4 => '红漆'
            // ]
        ],

    ]

];

