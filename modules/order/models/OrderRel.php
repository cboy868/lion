<?php

namespace app\modules\order\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\user\models\User;

/**
 * This is the model class for table "{{%order_rel}}".
 *
 * @property integer $id
 * @property integer $wechat_uid
 * @property string $title
 * @property integer $type
 * @property integer $category_id
 * @property integer $goods_id
 * @property integer $order_id
 * @property string $price
 * @property string $price_unit
 * @property integer $num
 * @property string $use_time
 * @property string $note
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class OrderRel extends \app\core\db\ActiveRecord
{
    const STATUS_NORMAL = 1;
    const STATUS_DEL = -1;

    // const TYPE_FOOD = 1; //订餐
    // const TYPE_SEAT = 2; //订桌


    const EVENT_AFTER_CREATE = 'afterCreate';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_rel}}';
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
            [['wechat_uid', 'type', 'category_id', 'goods_id', 'order_id', 'num', 'created_at', 'updated_at', 'status', 'sku_id', 'user_id'], 'integer'],
            [['price', 'price_unit'], 'number'],
            [['use_time'], 'safe'],
            [['note'], 'string'],
            [['order_id', 'goods_id'], 'required'],
            [['title', 'sku_name'], 'string', 'max' => 255],
        ];
    }


    public static function create($order, $sku, $data)
    {

        $model = OrderRel::hasRel($order->id, $sku->goods_id, $sku->id, $order->user_id);

        if (!$model) {
            $model = new OrderRel;
        }

        $num = $data['num']>0 ? $data['num'] : 1;

        $data = [
            'user_id'    => $order->user_id,
            'order_id'      => $order->id,
            'goods_id'      => $sku->goods_id,
            'sku_id'        => $sku->id,
            'category_id'   => $sku->goods->category_id,
            'title'         => $sku->name,
            'price_unit'    => $sku->price,
            'price'         => $num * $sku->price,
            'sku_name'      => $sku->name,
            'num'           => $num,
            'note'          => $data['note'] ? $data['note'] : '',
            'use_time'      => $data['use_time'] ? $data['use_time'] : date('Y-m-d H:i:s', strtotime('+3 day')),
        ];


        $model->load($data, '');

        $model->save();

        return $model;
    }

    // public static function create($wechat_uid, $order_id, $goods_model, $sku_model, array $extra=[] , $type=self::TYPE_FOOD)
    // {
    //     $model = self::hasRel($order_id, $goods_model->id, $sku_model->id);

    //     if (!$model) {
    //         $model = new self;
    //         $model->order_id = $order_id;
    //         $model->goods_id = $goods_model->id;
    //         $model->sku_id = $sku_model->id;
    //         $model->sku_name = $sku_model->name;
    //         $model->price_unit = $sku_model->price;
    //         $model->category_id = isset($goods_model->category_id) ? $goods_model->category_id : 0;
    //     }

    //     $model->type = $type;
    //     $model->title = $goods_model->name . ($type == self::TYPE_FOOD ? '' : ' 订桌');
    //     $model->wechat_uid = $wechat_uid;
    //     $model->num   = isset($extra['num']) ? $extra['num'] : 1;
    //     $model->price = $model->price_unit * $model->num;
    //     $model->use_time = isset($extra['use_time']) ? $extra['use_time'] : date('Y-m-d H:i:s');
    //     $model->note = isset($extra['note']) ? $extra['note'] : '';

    //     $model->save();

    //     return $model;
    // }

    public static function hasRel($order_id, $goods_id, $sku_id, $user_id)
    {
        return self::find()->where(['order_id'=>$order_id])
                             ->andWhere(['goods_id'=>$goods_id])
                             ->andWhere(['sku_id'=>$sku_id])
                             ->andWhere(['user_id'=> $user_id])
                             ->andWhere(['status'=>self::STATUS_NORMAL])
                             ->one();

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户',
            'title' => '商品名',
            'type' => 'Type',
            'category_id' => '商品分类',
            'goods_id' => '商品id',
            'order_id' => '订单id',
            'price' => '总价',
            'price_unit' => '单价',
            'num' => '数量',
            'use_time' => '使用时间',
            'note' => '备注',
            'created_at' => '添加时间',
            'updated_at' => '更新时间',
            'status' => '状态',
        ];
    }


    public function getStatusText()
    {
        $st = [
            self::STATUS_NORMAL => '正常',
            self::STATUS_DEL => '删除'
        ];
        return $st[$this->status];
    }

    public function getOrder()
    {
        return $this->hasOne(Order::className(),['id'=>'order_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(),['id'=>'user_id']);
    }

}
