<?php

namespace api\common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\user\models\User;
use app\modules\order\models\Order;
/**
 * This is the model class for table "{{%order_pay}}".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $order_no
 * @property integer $trade_no
 * @property string $total_fee
 * @property string $total_pay
 * @property integer $pay_method
 * @property integer $pay_result
 * @property integer $wechat_uid
 * @property string $paid_at
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $checkout_at
 * @property string $note
 * @property integer $status
 */
class OrderPay extends \app\core\db\ActiveRecord
{
    const STATUS_NORMAL = 1;
    const STATUS_DEL = -1;

    const METHOD_UNKNOWN = 0;
    const METHOS_CASH = 1;
    const METHOD_WECHAT = 2;
    const METHOD_ALI = 3;
    const METHOD_CHEQUE = 4;


    const RESULT_FAIL = -1;
    const RESULT_INIT = 0;
    const RESULT_FINISH = 1; //这里的完成，是本支付记录完成，不并不是本订单完成

    const EVENT_BEFORE_PAY = 'beforePay';
    const EVENT_AFTER_PAY = 'afterPay';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_pay}}';
    }

    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'pay_method', 'pay_result', 'wechat_uid', 'created_at', 'updated_at', 'status', 'op_id'], 'integer'],
            [['total_fee', 'total_pay'], 'number'],
            [['paid_at', 'checkout_at'], 'safe'],
            [['order_id', 'order_no'], 'required'],
            [['note', 'order_no', 'trade_no'], 'string'],
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
            'order_no' => '订单号',
            'trade_no' => '支付号',
            'total_fee' => '总金额',
            'total_pay' => '支付金额',
            'pay_method' => '支付方式',
            'pay_result' => '支付结果',
            'wechat_uid' => '用户',
            'paid_at' => '支付时间',
            'created_at' => '添加时间',
            'updated_at' => '更新时间',
            'checkout_at' => '结算时间',
            'note' => '备注',
            'status' => '状态',
        ];
    }

    public static function check($date=null)
    {
        $date = $date == null ? date('Y-m-d H:i:s') : $date;
        
        Yii::$app->db->createCommand()
                    ->update(
                        self::tableName(),
                        ['checkout_at'=>$date],
                        ['checkout_at'=>null]
                    )->execute();
    }


    /**
     * @name 支付记录创建
     */
    public static function create($order)
    {

        $cnt = Pay::find()->where(['order_id'=>$order->id, 'status'=>1])->count();

        //订单不存在
        if (!$order) {//'订单不存在';
            return false;
        }

        if ($order->progress > Order::PRO_PAY ) {//'订单已支付完成';
            return false;
        }


        # 几种情况
        # 1､未支付过
        # 2､已经支付部分

        // if ($total_pay >= $order->price) {//'订单已支付完成';
        //     return false;
        // }

        if ($order->isFinish) {
            return false;
        }

        $total_pay = $order->getTotalPay();

        $pay = self::find()->where(['order_id'=>$order->id, 'pay_result'=>self::RESULT_INIT, 'status'=>self::STATUS_NORMAL])->one();

        $remainder = $total_pay ? ($order->price - $total_pay) : $order->price;

        //8位日期 + 6位订单号(左补0) + 2位自动编号(同一订单支付次数) 如果不够用，规则以后再加也没关系
        $order_no = date('Ymd') . str_pad($order->id, 6, '0', STR_PAD_LEFT) . str_pad($cnt+1, 2, '0', STR_PAD_LEFT);

        if (!$pay) {
            $pay = new self;
            $pay->order_id = $order->id;
            $pay->pay_result = self::RESULT_INIT;
            $pay->order_no = $order_no;
            $pay->pay_method = self::METHOD_UNKNOWN;
            $pay->user_id = $order->user_id;
            $pay->op_id = Yii::$app->user->id;
        }
        $pay->total_fee = $remainder;
        $pay->total_pay = 0;

        if(!$pay->save()){ //'创建支付记录出现问题';
            return false;
        }

        return $pay;
    }

    // public static function getTotalPay($order)
    // {
    //     return self::find()->where([
    //         'order_id'  => $order->id, 
    //         'pay_result'=> SELF::RESULT_FINISH, 
    //         'status'    => self::STATUS_NORMAL
    //         ])->sum('total_pay');
    // }

    /**
     * @name 支付方法
     * @todo 第三方支付方法，肯定是要传进来trade_no,order_no之类
     */
    // public static function pay($order_no, $pay_method, $price)
    // {
    //     $model = self::find()->where([
    //         'order_no'=>$order_no, 
    //         'status'=>self::STATUS_NORMAL,
    //         'pay_result' => self::RESULT_INIT
    //         ])->one();
    //     if (!$model) { //'支付记录不存在,请重试';
    //         return false;
    //     }

    //     $model->pay_method = $pay_method;
    //     $model->total_pay  = $price;
    //     $model->paid_at    = date('Y-m-d H:i:s');
    //     $model->pay_result = self::RESULT_FINISH;
    //     if (!$model->save()) {
    //         return false;
    //     }

    //     // $total_pay = self::find()->where([
    //     //     'order_id'  => $order->id, 
    //     //     'pay_result'=> SELF::RESULT_FINISH, 
    //     //     'status'    => self::STATUS_NORMAL
    //     //     ])->sum('total_pay');
    // }


    // public static function pay($order, $pay_method, $pay_price)
    // {
    //     $pay = self::create($order);


    //     if (!$pay) {
    //         return false;
    //     }

    //     if ($pay->status == self::STATUS_DEL || $pay->pay_result != self::RESULT_INIT) {
    //         return false;
    //     }

    //     $pay->pay_method = $pay_method;
    //     $pay->total_pay  = $pay_price;
    //     $pay->paid_at    = date('Y-m-d H:i:s');
    //     $pay->pay_result = self::RESULT_FINISH;

    //     if (!$pay->save()) {
    //         return false;
    //     }

    //     if ($pay->total_fee > $pay->total_pay) {
    //         $progress = 1;
    //     } else {
    //         $progress = 2;
    //     }

    //     $event = new PayEvent(['progress' => $progress]);
    //     $pay->on(self::EVENT_AFTER_PAY, [$pay->order, 'afterPay']);
    //     $pay->trigger(self::EVENT_AFTER_PAY, $event);

    // }

    public function pay($pay_method, $pay_price)
    {

        if ($this->status == self::STATUS_DEL || $this->pay_result != self::RESULT_INIT) {
            return false;
        }

        $this->pay_method = $pay_method;
        $this->total_pay  = $pay_price;
        $this->paid_at    = date('Y-m-d H:i:s');
        $this->pay_result = self::RESULT_FINISH;

        if (!$this->save()) {
            return false;
        }

        if ($this->total_fee > $this->total_pay) {
            $progress = 1;
        } else {
            $progress = 2;
        }

        $event = new PayEvent(['progress' => $progress == 1 ? Order::PRO_PART : Order::PRO_PAY]);
        
        $this->trigger(self::EVENT_AFTER_PAY, $event);
    }


    // public function pay($pay_method, $pay_price)
    // {

    //     if ($this->status == self::STATUS_DEL || $this->pay_result != self::RESULT_INIT) {
    //         return false;
    //     }

    //     $this->pay_method = $pay_method;
    //     $this->total_pay  = $pay_price;
    //     $this->paid_at    = date('Y-m-d H:i:s');
    //     $this->pay_result = self::RESULT_FINISH;


    //     if (!$this->save()) {
    //         return false;
    //     }

    //     if ($this->total_fee > $this->total_pay) {
    //         $progress = 1;
    //     } else {
    //         $progress = 2;
    //     }

    //     $event = new PayEvent(['progress' => $progress]);
    //     $this->on(self::EVENT_AFTER_PAY, [$this->order, 'afterPay']);
    //     $this->trigger(self::EVENT_AFTER_PAY, $event);

    // }

    public function getOrder()
    {
        return $this->hasOne(Order::className(),['id'=>'order_id']);
    }
    public function getUser()
    {
        return $this->hasOne(User::className(),['id'=>'user_id']);
    }

    public static function getPayByOrder($order_id)
    {
        return Pay::find()->where(['order_id'=>$order_id])->asArray()->one();
    }

    public function getMethod()
    {
        return self::getMethods($this->pay_method);
    }

    public static function getMethods($method = null)
    {
        $me = [
            self::METHOS_CASH => '现金支付',
            self::METHOD_CHEQUE => '支票支付',
            self::METHOD_ALI => '支付宝支付',
            self::METHOD_WECHAT => '微信支付',
            self::METHOD_UNKNOWN => '其它',

        ];

        if ($method === null) {
            return $me;
        }

        return $me[$method];

    }


}
