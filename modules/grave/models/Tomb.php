<?php

namespace app\modules\grave\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\core\models\Attachment;
use app\core\traits\ThumbTrait;
use app\core\helpers\Url;
/**
 * This is the model class for table "{{%grave_tomb}}".
 *
 * @property integer $id
 * @property integer $grave_id
 * @property integer $row
 * @property integer $col
 * @property string $special
 * @property string $tomb_no
 * @property integer $hole
 * @property string $price
 * @property string $cost
 * @property double $area_total
 * @property double $area_use
 * @property integer $user_id
 * @property integer $customer_id
 * @property integer $agent_id
 * @property integer $agency_id
 * @property integer $guide_id
 * @property string $sale_time
 * @property string $note
 * @property integer $thumb
 * @property integer $created_at
 * @property integer $status
 * 退墓的设计，修改原墓位状态，其它不变，添加一新墓位，墓位号改为目前的，与已退墓位id关联
 */
class Tomb extends \app\core\db\ActiveRecord
{

    use ThumbTrait;

    // 1删除,1闲置，2预定，3定金 4全款，5 部分安葬 6全部安葬 7单葬
    const STATUS_DELETE = -1; //删除
    const STATUS_EMPTY = 1; //闲
    const STATUS_SAVE = 3; //保留

    const STATUS_PRE = 5; //预定
    const STATUS_DEPOSIT = 7; //定金
    const STATUS_PAYOK = 9; //支付完成
    const STATUS_PART = 11; //部分安葬
    const STATUS_ALL = 13; //全部安葬 
    const STATUS_SINGLE = 15; //单葬完成

    const STATUS_RETURN = -2; //退墓

    //以下这些状态放到退墓表中
    // const RETURN_DEPOSIT = 1;//订金退
    // const RETURN_IN = 3; //退墓迁本园
    // const RETURN_OUT = 5;//退墓迁出

    // const RETURN_DEPOSIT_OK = 2;//订金退
    // const RETURN_IN_OK = 4; //退墓迁本园
    // const RETURN_OUT_OK = 6;//退墓迁出

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_tomb}}';
    }

    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at']
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['grave_id', 'row', 'col', 'hole', 'user_id', 'customer_id', 'agent_id', 'agency_id', 'guide_id', 'created_at', 'status'], 'integer'],
            [['price', 'cost', 'area_total', 'area_use'], 'number'],
            [['sale_time', 'thumb'], 'safe'],
            [['note'], 'string'],
            [['grave_id', 'tomb_no', 'row', 'col'], 'required'],
            [['special'], 'string', 'max' => 100],
            [['tomb_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'grave_id' => '墓区',
            'row' => '排',
            'col' => '号',
            'special' => 'Special',
            'tomb_no' => '墓位号',
            'hole' => '墓穴个数',
            'price' => '墓价',
            'cost' => 'Cost',
            'area_total' => '建筑面积',
            'area_use' => '使用面积',
            'user_id' => '用户',
            'customer_id' => '客户',
            'agent_id' => '业务员',
            'agency_id' => '办事处',
            'guide_id' => '导购员',
            'sale_time' => '销售时间',
            'note' => '备注',
            'thumb' => '封面',
            'created_at' => '添加时间',
            'status' => '状态',
        ];
    }

    public static function getSta($status = null)
    {
        $sta = [
            self::STATUS_DELETE => '删除',
            self::STATUS_EMPTY => '闲置',
            self::STATUS_PRE => '预定',
            self::STATUS_DEPOSIT => '定金',
            self::STATUS_PAYOK => '全款',
            self::STATUS_PART => '部分安葬',
            self::STATUS_ALL => '全部安葬',
            self::STATUS_SINGLE => '单葬'
        ];

        if ($status == null) {
            return $sta;
        }

        return isset($sta[$status]) ? $sta[$status] : '';

    }

    public function getGrave()
    {
        return $this->hasOne(Grave::className(),['id'=>'grave_id']);
    }


    /**
     * 获取此墓位上可以进行的操作
     **/
    public function getOptions()
    {
        


        $options = [
            'common' => [
                [
                    '一墓一档',
                    Url::toRoute(['/grave/admin/tomb/view', 'id'=>$this->id]),
                    'tomb-detail'
                ],
                [
                    '购买商品',
                    '#',
                    'tomb-shop'
                ]
            ],//一般操作
            
        ];

        // common

        // $common = [];
        $common =& $options['common'];

       

        if ($this->status == self::STATUS_EMPTY) {
            $common = array_merge($common,[
                [
                    '预订',
                    '/admin/tombpre/preorder/id/'.$id,
                    'tomb-preorder'
                ],
                [
                    '保留',
                    '/admin/tomb/retain/id/'.$id,
                    'tomb-retain'
                ]
            ]);
        } else if ($this->status == self::STATUS_SAVE) {
            $common[] = [
                '取消保留',
                '/admin/tomb/retain/id/'.$id,
                'tomb-retain-del'
            ];
        } else if ($this->status == self::STATUS_PRE) {
            $common[] = [
               '取消预订',
               '/admin/tombpre/unpreorder?tomb_id='.$id,
               'tomb-unpreorder'
           ];
        } 

        $opt_url = Yii::$app->controller->module->params['process'];
        if ($this->status > self::STATUS_SAVE) {
            $options['operate'] = [];
            $operate =& $options['operate'];
            foreach ($opt_url as $key=>$opt) {
                if (8 == $key) continue;
                $operate[] = [
                    $opt['text'],
                    $opt['url'].'?tomb_id='.$id.'#'.$opt['name'],
                    'tomb-opt'
                ];
            }
        }

        if ($this->status > self::STATUS_PRE) {

            $options['tombwithdraw'] = [];
            $tombwithdraw =& $options['tombwithdraw'];
            $url = '/admin/tombwithdraw/add?tomb_id=' . $id . '&type=';

            $tombwithdraw[] = [
                '退款',
                '/admin/refund/add?tomb_id='.$tomb['id'],
                'tomb-detail',
            ];

            if ($this->status == self::STATUS_DEPOSIT) {
                $tombwithdraw = [
                    [
                        '订金退墓',
                         $url.'1',
                    ],
                    [
                        '订金换墓',
                         $url.'5',
                    ]
                ];
            }

            if ($this->status == self::STATUS_PAYOK) {
                $tombwithdraw = [
                    [
                        '全款退墓',
                         $url.'2',
                    ],
                    [
                        '退墓迁本园',
                         $url.'3',
                    ]

                ];
            }

            if (in_array($this->status, [self::STATUS_PART, self::STATUS_ALL, self::STATUS_SINGLE])) {
                $tombwithdraw = [
                    [
                        '退墓迁本园',
                         $url.'3',
                    ],
                    [
                        '退墓迁出',
                         $url.'4',
                    ]
                ];
            }
        }

        if ($this->status > self::STATUS_PAYOK) {
            $options['careful'][] = [
                '改墓',
                '/admin/changetomb/change/?tomb_id='.$id
            ];
        }



      

//         // common  ----------------------------------------------------
//         $sale_status =& $tomb['sale_status'];
//         $option['common'] = array();
//         $common =& $options['common'];
        
//         /*
//         $common[] = array(
//                 '一墓一档',                     // 标题
//                 '/admin/tomb/detail/id/'.$id,  // 链接
//                 'tomb-detail'                  // class
//             );*/
        
//         // 普通 预订
//         if ($sale_status == 1) { // 闲置状态
//             // 推荐处理
//             if ($tomb['recommand'] == 0) {
//                 $common[] = array(
//                     '推荐该墓位',
//                     '/admin/tomb/recommand/id/'.$id,
//                     'tomb-recommand'
//                 );
//             } else {
//                 $common[] = array(
//                     '取消推荐',
//                     '/admin/tomb/unrecommand/id/'.$id,
//                     'tomb-unrecommand'
//                 );
//             }

            // $common[] = array(
            //     '预订',
            //     '/admin/tombpre/preorder/id/'.$id,
            //     'tomb-preorder'
            // );


            // $common[] = array(
            //     '保留',
            //     '/admin/tomb/retain/id/'.$id,
            //     'tomb-retain'
            // );
//         } 

//         if ($sale_status == -1) {
            // $common[] = array(
            //     '取消保留',
            //     '/admin/tomb/retain/id/'.$id,
            //     'tomb-retain-del'
            // );
//         }

//         // 普通 预订
// //        if ($sale_status == 2) { // 取消预订,  指预订,没有交订金
           // $common[] = array(
           //     '取消预订',
           //     '/admin/tombpre/unpreorder?tomb_id='.$id,
           //     'tomb-unpreorder'
           // );
// //        }

//         // 进入他的后台
//         if($canProcess && !empty($tomb['user_id'])) {
//             $common[] = array(
//                 '进入他的后台',                                  // 标题
//                 '/admin/tomb/access/user_id/'.$tomb['user_id'],  // 链接
//                 'tomb-detail'                                    // class
//             );
//         }

//         // 激活判断 [是否为老数据]，[1:是,0:否,10:激活未完成,20:已激活]
//         if ($tomb['is_old'] != 0 && $tomb['sale_status'] > 1 ) {  // TODO 完善激活条件
//             $is_old = $tomb['is_old'];
//             switch ($is_old) {
//                 case 1:
//                     $common[] = array(
//                         '激活墓位',
//                         '/admin/actcus/process?tomb_id='.$tomb['id'],
//                         'tomb-active',
//                     );
//                     break;

//                 case 10:
//                     $common[] = array(
//                         '继续激活',
//                         '/admin/actcus/process?tomb_id='.$tomb['id'],
//                         'tomb-active',
//                     );
//                     break;

//                 case 20:
//                     // 如果有任意一个未付款的
//                     $option = array(
//                         'tomb_id' => $tomb['id'],
//                         'status'  => 1,
//                     );
//                     $OrderInfo = M('order_info');
//                     $order_infos = $OrderInfo->where($option)->select();
//                     $flag = true;
//                     foreach($order_infos as $order) {
//                         if ($order['progress'] != 0) {
//                             $flag = false;
//                             break;
//                         }
//                     }
//                     if ($flag) {
//                         $common[] = array(
//                             '重新激活',
//                             '/admin/actcus/process?tomb_id='.$tomb['id'],
//                             'tomb-active',
//                         );
//                     }
//                     break;
//                 default:
//                     // code...
//                     break;
//             }

//         }


        
//         // 流程操作-----------------------------------------------------
//         if ($canProcess && $sale_status > 1) {
//            $options['operate'] = array();
//            $operate =& $options['operate'];
//            $opt_url = C('PROCESS_MENU');

           // foreach ($opt_url as $key=>$opt) {
           //      if (8 == $key) continue;
           //      $operate[] = array(
           //          $opt['text'],
           //          $opt['url'].'?tomb_id='.$id.'#'.$opt['name'],
           //          'tomb-opt'
           //      );
           //  }
//         }
        

//         // 退墓操作-----------------------------------------------------
//         if ($canProcess && ($sale_status > 2 and $sale_status <=6)) {
        //     $options['tombwithdraw'] = array();
        //     $tombwithdraw =& $options['tombwithdraw'];
        //     $url = '/admin/tombwithdraw/add?tomb_id='
        //          . $id
        //          . '&type=';
        //     $tombwithdraw[] = array(
        //                 '退款',
        //                 '/admin/refund/add?tomb_id='.$tomb['id'],
        //                 'tomb-detail',
        //             );
        //     if ($sale_status == 3) { // 订金
        //         $tombwithdraw[] = array(
        //             '订金退墓',
        //              $url.'1',
        //         );     
        //         $tombwithdraw[] = array(
        //             '订金换墓',
        //              $url.'5',
        //         );     
        //     }
            
        //     if ($sale_status == 4) { // 全款
        //         $tombwithdraw[] = array(
        //             '全款退墓',
        //              $url.'2',
        //         );     
        //         $tombwithdraw[] = array(
        //             '退墓迁本园',
        //              $url.'3',
        //         );     
        //     }
            
        //     if (in_array($sale_status, array(5,6))) { // 迁墓
        //         $tombwithdraw[] = array(
        //             '退墓迁本园',
        //              $url.'3',
        //         );     
        //         $tombwithdraw[] = array(
        //             '退墓迁出',
        //              $url.'4',
        //         );     
        //     }

        // }

        // //  慎重操作----------------------------------------------------------
        // if ($canProcess && $sale_status > 3) { // 已经安葬或部分安葬 // 改为全款
        //     $options['careful'] = array();
        //     $careful = & $options['careful'];

        //     $careful[] = array(
        //         '改墓',
        //         '/admin/changetomb/change/?tomb_id='.$id
        //     );

        //     $careful[] = array(
        //         '改墓不换碑',
        //          '/admin/changetombonly/index/?tomb_id='.$id
        //     );

//         }
        return $options;
    }

    public function hasIns()
    {
        return Ins::find()->where(['tomb_id'=>$this->id, 'status'=>Ins::STATUS_NORMAL])->one();
    }

}
