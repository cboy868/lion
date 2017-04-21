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
    const STATUS_RETAIN = 9; //保留

    const STATUS_PRE = 2; //预定
    const STATUS_DEPOSIT = 3; //定金
    const STATUS_PAYOK = 4; //支付完成
    const STATUS_PART = 5; //部分安葬
    const STATUS_ALL = 6; //全部安葬 
    const STATUS_SINGLE = 7; //单葬完成

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
            [['note', 'mnt_by'], 'string'],
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
            // self::STATUS_DELETE => '删除',
            self::STATUS_EMPTY => '闲置',
            self::STATUS_PRE => '预定',
            self::STATUS_DEPOSIT => '定金',
            self::STATUS_PAYOK => '全款',
            self::STATUS_PART => '部分安葬',
            self::STATUS_ALL => '全部安葬',
            self::STATUS_SINGLE => '单葬',
            self::STATUS_RETAIN => '保留'
        ];

        if ($status == null) {
            return $sta;
        }
        return isset($sta[$status]) ? $sta[$status] : '';
    }

    public function getStatusText()
    {
        return self::getSta($this->status);
    }

    public function getGrave()
    {
        return $this->hasOne(Grave::className(),['id'=>'grave_id']);
    }

    public function getGuide()
    {
        if (!$this->guide_id) {
            return '';
        }
        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'guide_id']);
    }

    public function getAgent()
    {
        if (!$this->agent_id) {
            return '';
        }
        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'agent_id']);
    }

    public function getUser()
    {

        if (!$this->user_id) {
            return '';
        }
        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'user_id']);
    }

    public function getCard()
    {
        return $this->hasOne(\app\modules\grave\models\Card::className(),['tomb_id'=>'id']);//->orderBy('id asc');
    }
    public function getIns()
    {
        return $this->hasOne(\app\modules\grave\models\Ins::className(),['tomb_id'=>'id']);
    }

    public function getMemorial()
    {
        return $this->hasOne(\app\modules\memorial\models\Memorial::className(),['tomb_id'=>'id']);
    }

    public function getCustomer()
    {
        return $this->hasOne(\app\modules\grave\models\Customer::className(),['id'=>'customer_id']);
    }

    public function getDeads()
    {
        return $this->hasMany(Dead::className(),['tomb_id'=>'id'])->where(['status'=>self::STATUS_NORMAL]);
    }


    public function pre($flag = true, $client_id=null)
    {
        if (!$flag && $this->status == self::STATUS_PRE) {
            $this->status = self::STATUS_EMPTY;
            return $this->save();
        }

        if ($flag && ($this->status == self::STATUS_EMPTY || $this->status == self::STATUS_RETAIN)) {

            $this->status = self::STATUS_PRE;


            try {
                $outerTransaction = Yii::$app->db->beginTransaction();
                if ($client_id) {
                    $client = \app\modules\client\models\Client::findOne($client_id);

                    $data = [
                        'client_id' => $client->id,
                        'name' => $client->name,
                        'mobile' => $client->mobile,
                        'tomb_id' => $this->id,
                        'phone' => $client->telephone,
                        'email' => $client->email,
                        'province' => $client->province_id,
                        'city' => $client->city_id,
                        'zone' => $client->zone_id,
                        'addr' => $client->address,
                    ];
                    $customer = new Customer();
                    $customer->load($data, '');

                    $customer->save();

                    $deal = \app\modules\client\models\Deal::create($client_id, $client->guide_id, $client->agent_id, 'tomb', $this->id, $this->tomb_no);
                    $this->customer_id = $customer->id;

                }

                $this->save();
                $outerTransaction->commit();

                return $this;
            } catch (\Exception $e) {
                $outerTransaction->rollBack();
            }
        }

        return false;
    }

    public function retain($flag = true)
    {
        if (!$flag && $this->status == self::STATUS_RETAIN) {
            $this->status = self::STATUS_EMPTY;
            return $this->save();
        }


        if ($flag && $this->status == self::STATUS_EMPTY) {
            $this->status = self::STATUS_RETAIN;
            return $this->save();
        }
        return false;
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
                    Url::toRoute(['/grave/admin/mall/index', 'tomb_id'=>$this->id]),
                    'tomb-shop'
                ],
                [
                    '特殊商品',
                    '#',
                    'special-goods'
                ]
                
            ],//一般操作
            
        ];

        $common =& $options['common'];

        if ($this->status == self::STATUS_EMPTY) {
            $common = array_merge($common,[
                [
                    '预订',
                    Url::toRoute(['/grave/admin/tomb/pre', 'id'=>$this->id, 'client_id'=>Yii::$app->request->get('client_id')]),
                    'tomb-preorder'
                ],
                [
                    '保留',
                    Url::toRoute(['/grave/admin/tomb/retain', 'id'=>$this->id]),
                    'tomb-retain'
                ]
            ]);
        } else if ($this->status == self::STATUS_RETAIN) {
            $common[] = [
                '取消保留',
                Url::toRoute(['/grave/admin/tomb/un-retain', 'id'=>$this->id]),
                'tomb-retain-del'
            ];
        } else if ($this->status == self::STATUS_PRE) {
            $common[] = [
               '取消预订',
               Url::toRoute(['/grave/admin/tomb/un-pre', 'id'=>$this->id]),
               'tomb-unpreorder'
           ];
        } 

        $opt_url = Yii::$app->controller->module->params['process'];

        if ($this->status >self::STATUS_EMPTY && $this->status != self::STATUS_RETAIN) {
            $options['operate'] = [];
            $operate =& $options['operate'];
            foreach ($opt_url as $key=>$opt) {
                if (8 == $key) continue;
                $operate[] = [
                    $opt['text'],

                    Url::toRoute([$opt['url'], 'tomb_id'=>$this->id, 'step'=>$opt['step']]),
                    // $opt['url'].'?tomb_id='.$this->id.'#'.$opt['name'],
                    'tomb-opt'
                ];
            }
        }

        if ($this->status > self::STATUS_PRE && $this->status != self::STATUS_RETAIN) {

            $options['tombwithdraw'] = [];
            $tombwithdraw =& $options['tombwithdraw'];
            $url = '/admin/tombwithdraw/add?tomb_id=' . $this->id . '&type=';

            $tombwithdraw[] = [
                '退款',
                '/admin/refund/add?tomb_id='.$this->id,
                'tomb-detail',
            ];

            if ($this->status == self::STATUS_DEPOSIT) {
                $tombwithdraw = [
                    [
                        '订金退墓',
                         $url.'1',
                         'ding_refund'

                    ],
                    [
                        '订金换墓',
                         $url.'5',
                         'ding_move'
                    ]
                ];
            }

            if ($this->status == self::STATUS_PAYOK) {
                $tombwithdraw = [
                    [
                        '全款退墓',
                         $url.'2',
                         'tomb_refund'
                    ],
                    [
                        '退墓迁本园',
                         $url.'3',
                         'tomb_move'
                    ]

                ];
            }

            if (in_array($this->status, [self::STATUS_PART, self::STATUS_ALL, self::STATUS_SINGLE])) {
                $common[] = [
                    '续费',
                    Url::toRoute(['/grave/admin/tomb/renew', 'id'=>$this->id]),
                    'tomb-shop'
                ];
                $common[] = [
                    '修金箔',
                    Url::toRoute(['/grave/admin/tomb/repair', 'id'=>$this->id]),
                    'tomb-shop'
                ];

                $tombwithdraw = [
                    [
                        '退墓迁本园',
                         $url.'3',
                         'tomb_move'
                    ],
                    [
                        '退墓迁出',
                         $url.'4',
                         'tomb_refund'
                    ]
                ];
            }
        }

        if ($this->status > self::STATUS_PAYOK && $this->status != self::STATUS_RETAIN) {
            $options['careful'][] = [
                '改墓',
                Url::toRoute(['/grave/admin/tomb/renovate', 'id'=>$this->id]),
                'modify'
            ];
        }

        return $options;
    }

    public function hasIns()
    {
        return Ins::find()->where(['tomb_id'=>$this->id, 'status'=>Ins::STATUS_NORMAL])->one();
    }

    public function getImg($size, $default="/static/images/up.png")
    {
        return Attachment::getById($this->thumb, $size, $default);
    }

    public function saveAttach($info)
    {
        $this->thumb = $info['mid'];
        return $this->save();
    }

}
