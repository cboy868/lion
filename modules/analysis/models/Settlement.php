<?php

namespace app\modules\analysis\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\order\models\Order;
use app\modules\order\models\Pay;


/**
 * This is the model class for table "{{%settlement}}".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $op_id
 * @property integer $guide_id
 * @property integer $agent_id
 * @property integer $type
 * @property integer $pay_type
 * @property string $ori_price
 * @property string $price
 * @property integer $year
 * @property integer $month
 * @property integer $week
 * @property integer $day
 * @property string $settle_time
 * @property string $pay_time
 * @property string $intro
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Settlement extends \app\core\db\ActiveRecord
{

    const TYPE_DINGJIN = 1;
    const TYPE_CHONG   = 2;
    const TYPE_CHONGANDFULL = 3;
    const TYPE_FULL = 4;
    const TYPE_REFUND = 5;
    const TYPE_REFUNDTOMB = 6;


    /**
     * @name 结账
     */
    public static function check($date = null)
    {


        $date = $date == null ? date('Y-m-d H:i:s') : $date;

        try {
            $connection = Yii::$app->db;
            $transaction = $connection->beginTransaction();
            $connection->createCommand()
                        ->update(
                            self::tableName(),
                            ['settle_time'=>$date],
                            ['settle_time'=>self::DTNULL, 'status'=>self::STATUS_NORMAL]
                        )->execute();
            Pay::check($date);
            SettlementRel::check($date);

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
        }

        return true;
    }

    public static function types($type = null)
    {
        $t = [
            self::TYPE_DINGJIN => '定金',
            self::TYPE_CHONG => '冲定金',
            self::TYPE_CHONGANDFULL => '冲定金全款',
            self::TYPE_FULL => '全款',
            self::TYPE_REFUND => '退款',
            self::TYPE_REFUNDTOMB => '退墓',

        ];

        if ($type === null) {
            return $t;
        }

        return $t[$type];
    }

    public function getPayType()
    {
        return Pay::getMethods($this->pay_type);
    }

    public function getTypeLabel()
    {
        return self::types($this->type);
    }


    public static function create($event)
    {

        $pay = $event->sender;

        $order = $pay->order;

        if ($order->progress == 0) {//订单尚未支付的
            return ;
        }

        $data = self::deal($pay);


        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            foreach ($data as &$v) {

                $settle = new self;
                $settle->load($v, '');
                $settle->save();


                if (in_array($v['type'], [self::TYPE_CHONGANDFULL, self::TYPE_FULL])) {
                    SettlementRel::create($order, $settle);
                }
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
        }
    }

    /**
     * @name 处理数据
     * @des 这个方法用做每次付款后，插入数据
     */
    public static function deal($pay)
    {

        $order = $pay->order;
        $settles = self::find()->where(['order_id'=>$pay->order_id, 'status'=>self::STATUS_NORMAL])
                               ->all();

        $cdata = [
            'op_id'    => Yii::$app->user->id,
            'guide_id' => 0,
            'agent_id' => 0,
            'year'     => date('Y'),
            'month'    => date('m'),
            'week'     => date('W'),
            'day'      => date('d'),
            'settle_time' => '0000-00-00 00:00:00',
            'order_id' => $order->id,
            'intro'    => $order->note,
            'created_at' => time(),
            'updated_at' => time(),
        ];

        $data = [];

        if ($order->progress == Order::PRO_PART) {
            $data[] = array_merge([
                'pay_type' => $pay->pay_method,
                'price'    => $pay->total_pay,
                'type'     => self::TYPE_DINGJIN,
                'pay_time' => $pay->paid_at,
            ], $cdata);
        }


        if ($order->progress == Order::PRO_PAY) {//冲定金全款 或 全款
            if (!$settles) {//直接全款
                $data[] = array_merge([
                    'pay_type' => $pay->pay_method,
                    'price'    => $pay->total_pay,
                    'type'     => self::TYPE_DINGJIN,
                    'pay_time' => $pay->paid_at,
                ], $cdata);
            } else {//冲定金全款 
                $pay_total = self::find()->where(['order_id'=>$pay->order_id, 'status'=>self::STATUS_NORMAL])->sum('price');

                //冲定金的
                $data[] = array_merge([
                    'pay_type' => $pay->pay_method,
                    'price'    => -$pay_total,
                    'type'     => self::TYPE_CHONG,
                    'pay_time' => $pay->paid_at,
                ], $cdata);

                //冲定金全款的
                $data[] = array_merge([
                    'pay_type' => $pay->pay_method,
                    'price'    => $pay_total + $pay->total_pay,
                    'type'     => self::TYPE_CHONGANDFULL,
                    'pay_time' => $pay->paid_at
                ], $cdata);
            }
        }


        return $data;
    }

    // public static function create($order_id)
    // {

    //     $order = Order::findOne($order_id);

    //     if (!$order) {
    //         return ;
    //     }

    //     //支付记录
    //     $pays = $order->settles;//这个要取checkout_at不为空的,之前都取就会产生重复


    //     if ($order->progress == 0) {//订单尚未支付的
    //         return ;
    //     }

    //     if (count($pays) <= 0) {//无支付记录的，
    //         return ;
    //     }

    //     $data = self::deal($order);


    //     $connection = Yii::$app->db;
    //     $transaction = $connection->beginTransaction();
    //     try {

    //         foreach ($data as &$v) {
    //             ksort($v);
    //         }unset($v);

    //         //加入数据
    //         $connection->createCommand()->batchInsert(
    //             self::tableName(), 
    //             [
    //                 'agent_id',
    //                 'created_at',
    //                 'day',
    //                 'guide_id',
    //                 'intro',
    //                 'month',
    //                 'op_id',
    //                 'order_id',
    //                 'pay_time',
    //                 'pay_type',
    //                 'price',
    //                 'settle_time',
    //                 'type',
    //                 'updated_at',
    //                 'week',
    //                 'year'
    //             ], 
    //             $data
    //         )->execute();


    //         //更新支付表中所有checkout_date 为今天

    //         Pay::check($order_id);

    //         $transaction->commit();
    //     } catch (\Exception $e) {
    //         $transaction->rollBack();
    //     }
    // }

    /**
     * @name 处理数据
     * @des 这个方法是用做结账时统一插入数据的
     */
    // public static function deal($order)
    // {
    //     $cdata = [
    //         'op_id'    => Yii::$app->user->id,
    //         'guide_id' => 0,
    //         'agent_id' => 0,
    //         'year'     => date('Y'),
    //         'month'    => date('m'),
    //         'week'     => date('W'),
    //         'day'      => date('d'),
    //         'settle_time' => date('Y-m-d H:i:s'),
    //         'order_id' => $order->id,
    //         'intro'    => $order->note,
    //         'created_at' => time(),
    //         'updated_at' => time(),
    //     ];

    //     $pays = $order->settles;
    //     $data = [];

    //     if ($order->progress == Order::PRO_PART) {
    //         foreach ($pays as $pay) {//这里的全是认金
    //             $data[] = array_merge([
    //                 'pay_type' => $pay->pay_method,
    //                 'price'    => $pay->total_pay,
    //                 'type'     => self::TYPE_DINGJIN,
    //                 'pay_time' => $pay->paid_at,
    //             ], $cdata);
    //         }
    //     }

    //     if ($order->progress == Order::PRO_PAY) {//冲定金全款 或 全款
    //         if (count($pays) == 1) { //直接就是全款

    //             $pay = $pays[0];

    //             $data[] = array_merge([
    //                 'pay_type' => $pay->pay_method,
    //                 'price'    => $pay->total_pay,
    //                 'type'     => self::TYPE_DINGJIN,
    //                 'pay_time' => $pay->paid_at,
    //             ], $cdata);
    //         } else {
    //             $last = array_shift($pays);//这个是一个冲定金一个冲定金全款

    //             $pay = 0;
    //             foreach ($pays as $pay) {//这里的全是定金
    //                 $data[] = array_merge([
    //                     'pay_type' => $pay->pay_method,
    //                     'price'    => $pay->total_pay,
    //                     'type'     => self::TYPE_DINGJIN,
    //                     'pay_time' => $pay->paid_at,
    //                 ], $cdata);
    //                 $pay += $pay->total_pay;
    //             }

    //             //冲定金
    //             $data[] = array_merge([
    //                 'pay_type' => $last->pay_method,
    //                 'price'    => -$pay,
    //                 'type'     => self::TYPE_CHONG,
    //                 'pay_time' => $pay->paid_at,
    //             ], $cdata);

    //             $data[] = array_merge([
    //                 'pay_type' => $last->pay_method,
    //                 'price'    => $pay + $last->total_pay,
    //                 'type'     => self::TYPE_CHONGANDFULL,
    //                 'pay_time' => $pay->paid_at
    //             ], $cdata);

    //         }
            
    //     }


    //     return $data;

    // }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%settlement}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'op_id', 'type', 'pay_type', 'price', 'settle_time'], 'required'],
            [['order_id', 'op_id', 'guide_id', 'agent_id', 'type', 'pay_type', 'year', 'month', 'week', 'day', 'status', 'created_at', 'updated_at'], 'integer'],
            [['price'], 'number'],
            [['settle_time', 'pay_time'], 'safe'],
            [['intro'], 'string'],
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
            'order_id' => '订单id',
            'op_id' => 'Op ID',
            'guide_id' => '导购员',
            'agent_id' => '业务员id',
            'type' => '类型',
            'pay_type' => '支付方式',
            'price' => '支付金额',
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
            'typeLabel' => '支付类型',
            'payType'   => '支付方式'
        ];
    }

    public function getRel()
    {
        return $this->hasMany(SettlementRel::className(),['settlement_id'=>'id']);
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
