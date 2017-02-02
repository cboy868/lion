<?php

namespace app\modules\shop\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\shop\models\Cart;
use app\modules\shop\models\Goods;
use app\modules\shop\models\SeatOrder;
use app\modules\shop\models\Sku;
/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $id
 * @property integer $wechat_uid
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


    const TYPE_FOOD = 1; //订餐
    const TYPE_SEAT = 2; //订桌

    const STATUS_DEL = -1;//删除
    const STATUS_NORMAL = 1;//正常

    const PRO_INIT = 1; //订单初始  待支付
    const PRO_PAY  = 2; //支付完成
    const PRO_OK   = 3; //订单完成，服务最终完成


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_order}}';
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
            [['wechat_uid', 'type', 'progress', 'created_at', 'updated_at', 'status'], 'integer'],
            [['price', 'origin_price'], 'number'],
            [['note'], 'string'],
            [['wechat_uid'], 'required'],
        ];
    }

    public static function pay($id)
    {
        $order = self::findOne($id);

        $order->progress = self::PRO_PAY;

        return $order->save();
    }

    public static function afterPay($id)
    {
        $detail = OrderRel::find()->where(['order_id'=>$id, 'status'=>OrderRel::STATUS_NORMAL])->asArray()->all();

        foreach ($detail as $k => $v) {
            if ($v['type'] == OrderRel::TYPE_SEAT) {
                SeatOrder::afterPay($v['order_id'],$v['goods_id']);
            }
        }
    }

    public static function create($wechat_uid, $carts, $extra=[])
    {

        if (!$carts) {
            return false;
        }

        $outerTransaction = Yii::$app->db->beginTransaction();

        try {
            
            $model = new self;
            $model->wechat_uid = $wechat_uid;
            // $model->type = $type;
            $model->note = isset($extra['order_note']) ? $extra['order_note'] : '';

            if (!$model->save()) {
                return false;                
            }
            $order_id = $model->id;


            foreach ($carts as $k => $v) {
                $goods_model = Goods::findOne($v['goods_id']);
                $sku_model = Sku::findOne($v['sku_id']);
                $rel = OrderRel::create($wechat_uid, $order_id, $goods_model, $sku_model, ['num'=>$v['num']], $v['type']);
                Cart::drop($wechat_uid, $v['goods_id']);
            }

            $outerTransaction->commit();
        } catch (Exception $e) {
            $outerTransaction->rollBack();
        }
        
        return $model;
    }

    /**
     * @name 订桌的订单
     */
    public static function seat($wechat_uid, $goods_model, $extra = [])
    {



        // if (!$model) {
            $model = new self;
            $model->wechat_uid = $wechat_uid;
            $model->type = self::TYPE_SEAT;
            $model->note = isset($extra['order_note']) ? $extra['order_note'] : '';
            if (!$model->save()) {
                return false;                
            }
        // }
        $order_id = $model->id;

        $rel = OrderRel::create($wechat_uid, $order_id, $goods_model, $extra, OrderRel::TYPE_SEAT);

        if (!$rel) {
            return false;
        }
        self::updatePrice($order_id);

        return $model;
    }

    public static function updatePrice($order_id)
    {
        $model = self::findOne($order_id);

        $model->price = $model->origin_price = OrderRel::find()
                                            ->where(['status'=>OrderRel::STATUS_NORMAL, 'order_id'=>$order_id])
                                            ->sum('price');

        $model->save();
    }

    /**
     * @name 取未支付的有效订单
     */
    public static function getValidOrder($wechat_uid)
    {
        $model = self::find()->where(['wechat_uid'=>$wechat_uid])
                             ->andWhere(['status'=>self::STATUS_NORMAL])
                             ->andWhere(['<', 'progress', self::PRO_PAY])
                             ->one();

        return $model;
    }

    public function getRels()
    {
        return $this->hasMany(OrderRel::className(), ['order_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(\modules\wechat\models\User::className(), ['id' => 'wechat_uid']);
    }

    public function getDetail()
    {
        $html = '';
        foreach ($this->rels as $k => $v) {
            $html .= $v->title ." (". $v->num ."份) ". $v->price .'元 <br>';
        }
        return $html;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'wechat_uid' => '用户id',
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
            self::PRO_PAY   => '支付完成',
            self::PRO_OK    => '订单完成'
        ];

        if (is_null($pro)) {
            return $arr;
        } else {
            return $arr[$pro];
        }
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
