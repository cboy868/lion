<?php

namespace app\modules\order\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\shop\models\Cart;
use app\modules\user\models\User;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $price
 * @property string $origin_price
 * @property integer $type
 * @property integer $progress
 * @property string $note
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class Order extends \app\core\db\ActiveRecord
{

    const STATUS_DEL = -1;//删除
    const STATUS_NORMAL = 1;//正常

    const PRO_INIT = 0; //订单初始  待支付
    const PRO_PART = 1; //支付部分
    const PRO_DELAY= 3; //欠款
    const PRO_PAY  = 5; //支付完成
    const PRO_OK   = 8; //订单完成，服务最终完成

    const TYPE_GOODS = 1;


    // const EVENT_AFTER_PAY= 'afterPay'; //支付完成会一些例如短信、任务之类的东西由系统自动发出
    // const EVENT_AFTER_DELAY= 'afterDelay'; //欠款申请之后，同样会有一些短信、任务之类的东西
    // const EVENT_FINISH_PAY= 'finishPay';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
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
            [['wechat_uid', 'type', 'progress', 'created_at', 'updated_at', 'status', 'user_id', 'op_id', 'tid'], 'integer'],
            [['price', 'origin_price'], 'number'],
            [['note'], 'string'],
            [['user_id'], 'required'],
        ];
    }

    public function afterPay($event)
    {

        $this->progress = $event->progress;

        //如果支付完成,发任务
        if ($this->progress ==  self::PRO_PAY || $this->progress == self::PRO_OK) {

            if ($this->tid) {
                \app\modules\task\models\Task::create($this->id, 'tomb', $this->tid);
            } else {
                \app\modules\task\models\Task::create($this->id);
            }
        }

        $this->save();
    }


    public static function create($user_id, $sku, $extra=[])
    {
        try {
            $order = self::getValidOrder($user_id, $extra);
            $rel = OrderRel::create($order, $sku, $extra);
            $order->updatePrice();

        } catch (\Exception $e) {
            return false;
        }

        return ['order'=>$order, 'rel'=>$rel];
    }


    public static function createGoods($user_id, $goods, $extra=[])
    {
        try {
            $order = self::getValidOrder($user_id, $extra);

            $rel = OrderRel::createGoods($order, $goods, $extra);

            $order->updatePrice();
        } catch (\Exception $e) {
            return false;
        }

        return ['order'=>$order, 'rel'=>$rel];
    }


    public function getTotalPay()
    {
        return Pay::find()->where([
            'order_id'  => $this->id, 
            'pay_result'=> Pay::RESULT_FINISH, 
            'status'    => Pay::STATUS_NORMAL
            ])->sum('total_pay');
    }

    public function getRemain()
    {
        return $this->price - $this->getTotalPay();
    }



    public function updatePrice()
    {
        $this->price = $this->origin_price = OrderRel::find()
                                            ->where(['status'=>OrderRel::STATUS_NORMAL, 'order_id'=>$this->id])
                                            ->sum('price');

        $this->save();
    }

    /**
     * @name 取未支付的有效订单, 如果没有，则创建新的
     */
    public static function getValidOrder($user_id,$extra=[])
    {

        $model = self::find()->where(['user_id'=>$user_id])
                             ->andWhere(['status'=>self::STATUS_NORMAL])
                             ->andWhere(['progress'=>self::PRO_INIT])
                             ->one();

        if (!$model) {
            $model = new self();
            $model->op_id = Yii::$app->user->id;
            $model->user_id = $user_id;
            $model->tid = isset($extra['tid']) ? $extra['tid'] : 0;
        }
        $model->type = isset($extra['type']) ? $extra['type'] : 1;
        $model->note = isset($extra['order_note']) ? $extra['order_note'] : '';

        if (!$model->tid && isset($extra['tid'])) {
            $model->tid = $extra['tid'];
        }

        $model->save();

        return $model;
    }

    public static function getOriOrder($user_id,$extra=[])
    {
        $model = self::find()->where(['user_id'=>$user_id])
                             ->andWhere(['status'=>self::STATUS_NORMAL])
                             ->andWhere(['progress'=>self::PRO_INIT])
                             ->one();


        return $model;
    }


    public function getRels()
    {
        return $this->hasMany(OrderRel::className(), ['order_id' => 'id'])->orderBy('price desc');
    }

    // public function getUser()
    // {
    //     return $this->hasOne(\modules\wechat\models\User::className(), ['id' => 'wechat_uid']);
    // }
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getPays()
    {
        return $this->hasMany(Pay::className(), ['order_id' => 'id'])->andWhere(['status'=>self::STATUS_NORMAL])->orderBy('id asc');
    }

    /**
     * @name 取没结过账的
     */
    public function getSettles()
    {
        return $this->hasMany(Pay::className(), ['order_id' => 'id'])
                    ->andWhere(['status'=>self::STATUS_NORMAL])
                    ->andWhere(['checkout_at'=>null])
                    ->orderBy('id asc');
    }

    public function getDelays()
    {
        return $this->hasMany(Delay::className(), ['order_id' => 'id']);
    }

    public function getDetail()
    {
        $html = '';
        foreach ($this->rels as $k => $v) {
            $html .= $v->title ." (". $v->num ."份) ". $v->price .'元 <br>';
        }
        return $html;
    }

    public function getIsFinish()
    {
        return $this->getTotalPay() >= $this->price;
    }

    /**
     * 延期支付
     */
    // public function delay()
    // {
    //     $this->progress = self::PRO_DELAY;
    //     return $this->save();
    // }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            // 'wechat_uid' => '用户id',
            'user_id' => '用户id',
            'price' => '价格',
            'origin_price' => '原价',
            'type' => '订餐类型', //1点餐 2订桌
            'progress' => '支付进度',
            'note' => '备注',
            'created_at' => '下单时间',
            'updated_at' => '最后一次更新',
            'status' => '状态',
        ];
    }

    public function getStaLabel()
    {
        $arr = [
            self::STATUS_NORMAL => '正常',
            self::STATUS_DEL    => '删除'
        ];

        return $arr[$this->status];
    }

    public static function status($status=null)
    {
        $arr = [
            self::STATUS_NORMAL => '正常',
            self::STATUS_DEL    => '删除'
        ];

        if (is_null($status)) {
            return $arr;
        } else {
            return $arr[$status];
        }
    }


    public static function pro($pro=null)
    {
        $arr = [
            self::PRO_INIT  => '待支付',
            self::PRO_PART  => '支付部分',
            self::PRO_DELAY => '延期付款',
            self::PRO_PAY   => '支付完成',
            self::PRO_OK    => '订单完成'
        ];

        if (is_null($pro)) {
            return $arr;
        } else {
            return $arr[$pro];
        }
    }

    public function getPro()
    {
        return self::pro($this->progress);
    }

    public static function types($type=null)
    {
        $arr = [
            self::TYPE_FOOD  => '订餐',
            self::TYPE_SEAT  => '订桌',
        ];

        if (is_null($type)) {
            return $arr;
        } else {
            return $arr[$type];
        }
    }


}
