<?php

namespace api\common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%order_log}}".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $op_id
 * @property string $old
 * @property string $diff
 * @property string $intro
 * @property integer $created_at
 */
class OrderLog extends ActiveRecord
{

    const TYPE_PRO = 1;
    const TYPE_FEE = 2;
    const TYPE_REL = 3;
    const TYPE_OTHER = 4;

    /**
     * @inheritdoc
     
     */
    public static function tableName()
    {
        return '{{%order_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'op_id', 'old'], 'required'],
            [['order_id', 'op_id', 'created_at', 'type'], 'integer'],
            [['old', 'diff', 'intro'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => '订单id',
            'op_id' => '操作人',
            'old' => '原数据',
            'diff' => '修改值',
            'intro' => '简述',
            'created_at' => '日志时间',
        ];
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    OrderLog::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    public static function create($order_id)
    {


        $order = Order::findOne($order_id);
        $rels = $order->rels;

        $relData = [];

        foreach ($rels as $rel) {
            $relData[$rel->id] = [
                'goods_id' => $rel->goods_id,
                'price' => $rel->price,
                'num'   => $rel->num,
                'note' =>$rel->note,
                'is_refund' => $rel->is_refund,
                'status' => $rel->status
            ];
        }
        $data = [
            'price' => $order->price,
            'origin_price' => $order->price,
            'progress' => $order->progress,
            'note' => $order->note,
            'rel'  => $relData,
        ];

        $old_log = self::find()->where(['order_id'=>$order_id])->orderBy('id desc')->one();


        $dtype = [
            Order::PRO_INIT => '订单初始化成功',
            Order::PRO_PART => '订单支付部分',// = 1; //支付部分
            Order::PRO_DELAY => '订单申请为欠款',//= 3; //欠款
            Order::PRO_PAY => '订单支付完成',//  = 5; //支付完成
            Order::PRO_OK => '订单服务完成'//   = 8; //订单完成，服务最终完成
        ];

        $dintro = '';
        $type = 4;
        $diff = [];

        if (!empty($old_log)) {
            $old_data = json_decode($old_log['old'], true);
            foreach ($data as $k => $v) {

                if ($k == 'rel') {
                    foreach ($data['rel'] as $key => $val) {
                        foreach ($val as $ke => $va) {
                            if (isset($old_data['rel'][$key]) && $val != $old_data['rel'][$key]) {
                                $diff[$k][$key][$ke] = $va;
                            }
                        }
                        if ($val['status'] == -1) {
                            $dintro .= '删除商品 商品id:' . $val['goods_id'];
                            $type = self::TYPE_REL;
                        }
                        if ($val['is_refund']) {
                            $dintro .= '商品退款 商品id:' . $val['goods_id'];
                        }
                    }

                } else {
                    if (isset($old_data[$k]) && $v != $old_data[$k]) {
                        $diff[$k] = $v;
                    }
                }
            }



            if ($data['progress'] != $old_data['progress']) {
                $dintro .= '订单状态改变, 改为:';
              
                $dintro = $dintro . $dtype[$data['progress']];
                $type = self::TYPE_PRO;
            }
                
            if ($data['price'] != $old_data['price']) {
                $dintro = $dintro . '订单更新价格成功';
                $type = self::TYPE_FEE;
            }

        } else {
            $dintro = $dtype[$data['progress']];
            $type = self::TYPE_PRO;
        }
        
        $model = new self;

        $model->order_id = $order_id;
        $model->op_id = Yii::$app->user->id;
        $model->old = json_encode($data);
        $model->diff = json_encode($diff);
        $model->intro = $dintro;
        $model->type = $type;

        return $model->save();
    }
}
