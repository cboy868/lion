<?php

namespace app\modules\analysis\models;

use app\core\helpers\ArrayHelper;
use app\modules\order\models\OrderRel;
use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\order\modls\Order;

/**
 * This is the model class for table "{{%settlement_rel}}".
 *
 */
class SettlementRel extends \app\core\db\ActiveRecord
{

    const STATUS_CHECK = 2;

    public static function check($date = null)
    {
        $date = $date == null ? date('Y-m-d H:i:s') : $date;
        Yii::$app->db->createCommand()
                        ->update(
                            self::tableName(),
                            ['settle_time'=>$date, 'status'=>self::STATUS_CHECK],
                            ['status'=>self::STATUS_NORMAL]
                        )->execute();
    }

    public static function create($order, $settlement)
    {
        $rels = $order->rels;

        $cdata = [
            'order_id' => $order->id,
            'op_id'     => Yii::$app->user->id,
            'settlement_id' => $settlement->id,
            'settle_time'   => $settlement->settle_time,
            'guide_id' => 0,
            'agent_id' => 0,
            'year'     => $settlement->year,
            'month'    => $settlement->month,
            'week'     => $settlement->week,
            'day'      => $settlement->day,
        ];

        $data = [];

        foreach ($rels as $k => $rel) {
            $res_name = $rel->type == 9 ? 'tomb' : 'goods';
            $nd = [
                'category_id' => $rel->category_id ? $rel->category_id : 0,
                'goods_id'    => $rel->goods_id,
                'sku_id'      => $rel->sku_id,
                'ori_price'   => $rel->price,
                'price'       => $rel->price,
                'res_name'    => $res_name,
                'num'         => $rel->num
            ];

            $srel = new self;
            $srel->load(array_merge($nd, $cdata), '');
            $srel->save();
        }

        return true;

    }

    public static function refund($refund, $settlement)
    {
        $rels = $refund->rels;
        $rids = ArrayHelper::getColumn($rels, 'rel_id');
        $order_rels = OrderRel::find()->where(['id'=>$rids])->all();

        $cdata = [
            'order_id' => $refund->order_id,
            'op_id'     => Yii::$app->user->id,
            'settlement_id' => $settlement->id,
            'settle_time'   => $settlement->settle_time,
            'guide_id' => 0,
            'agent_id' => 0,
            'year'     => $settlement->year,
            'month'    => $settlement->month,
            'week'     => $settlement->week,
            'day'      => $settlement->day,
        ];

        foreach ($order_rels as $k => $rel) {
            $res_name = $rel->type == 9 ? 'tomb' : 'goods';
            $nd = [
                'category_id' => $rel->category_id ? $rel->category_id : 0,
                'goods_id'    => $rel->goods_id,
                'sku_id'      => $rel->sku_id,
                'ori_price'   => $rel->price,
                'price'       => -$rels[$rel->id]['price'],//$rel->price,
                'res_name'    => $res_name,
                'num'         => $rels[$rel->id]['num']
            ];

            $srel = new self;
            $srel->load(array_merge($nd, $cdata), '');
            $srel->save();
        }

        return true;

    }

    public static function refundTomb($withdraw, $settlement)
    {

        $tomb = $withdraw->tomb;

        $order_rel = OrderRel::find()->where(['tid'=>$tomb->id,'type'=>9,'status'=>1])->one();

        $cdata = [
            'order_id' => isset($order_rel->order_id) ? $order_rel->order_id : 0,
            'op_id'     => Yii::$app->user->id,
            'settlement_id' => $settlement->id,
            'settle_time'   => $settlement->settle_time,
            'guide_id' => 0,
            'agent_id' => 0,
            'year'     => $settlement->year,
            'month'    => $settlement->month,
            'week'     => $settlement->week,
            'day'      => $settlement->day,
            'category_id' => $tomb->grave_id,
            'goods_id'    => $tomb->id,
            'sku_id'      => $tomb->id,
            'ori_price'   => $tomb->price,
            'price'       => $withdraw->price ? -$withdraw->price : 0,//$rel->price,
            'res_name'    => 'tomb',
            'num'         => 1
        ];

        $srel = new self;
        $srel->load($cdata, '');
        $srel->save();

//        Yii::error($srel->getErrors());


        return true;

    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%settlement_rel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'op_id', 'category_id', 'goods_id', 'sku_id', 'ori_price', 'price', 'settlement_id','num'], 'required'],
            [['order_id', 'op_id', 'guide_id', 'agent_id', 'category_id', 'goods_id', 'sku_id', 'type', 'year', 'month', 'week', 'day', 'status', 'created_at', 'updated_at', 'num'], 'integer'],
            [['ori_price', 'price'], 'number'],
            [['settle_time', 'pay_time'], 'safe'],
            [['intro'], 'string'],
            [['res_name'], 'string', 'max' => 100],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'settlement_id' => '主记录id',
            'order_id' => 'Order ID',
            'op_id' => '操作员',
            'guide_id' => '导购员',
            'agent_id' => '业务员',
            'res_name' => '类型',//goods  tomb ...
            'category_id' => '分类',
            'goods_id' => '商品',
            'sku_id' => 'Sku',
            'type' => '折算方式',//总款打折后，明细的分配方式 1按比例平均，2如有墓位,计算到墓位,如无墓位，按比例平均
            'ori_price' => '原价',
            'price' => '实付',
            'year' => '年',
            'month' => '朋',
            'week' => '周',
            'day' => '日',
            'settle_time' => '结帐时间',
            'pay_time' => '付款时间',
            'intro' => '备注',
            'status' => '状态',//订单删除时，这个也要删除
            'created_at' => '添加时间',
            'updated_at' => '修改时间',
        ];
    }

    public function getSettlement()
    {
        return $this->hasOne(Settlement::className(),['id'=>'settlement_id']);
    }

    public function getGuide()
    {
        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'guide_id']);
    }

    public function getAgent()
    {
        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'agent_id']);
    }

    public function getOp()
    {
        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'op_id']);
    }

    
}
