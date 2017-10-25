<?php

namespace app\modules\order\models;

use app\modules\grave\models\Tomb;
use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\user\models\User;
use app\modules\shop\models\Goods;

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

    const TYPE_GOODS = 1;//普通商品订单
    const TYPE_SPECIAL_GOODS = 11;//特殊商品

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
            [['wechat_uid', 'type', 'category_id', 'goods_id', 'order_id', 'num', 'created_at', 'updated_at', 'status', 'sku_id', 'tid', 'user_id', 'op_id', 'is_refund'], 'integer'],
            [['price', 'price_unit','original_price'], 'number'],
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


        $title = $sku->name;
        if ($sku->goods->name != $title) {
            $title = $sku->goods->name . $title;
        }

        $da = [
            'user_id'    => $order->user_id,
            'op_id'      => Yii::$app->user->id,
            'order_id'      => $order->id,
            'goods_id'      => $sku->goods_id,
            'sku_id'        => $sku->id,
            'category_id'   => $sku->goods->category_id,
            'title'         => $title,
            'price_unit'    => $sku->price,
            'price'         => $num * $sku->price,
            'sku_name'      => $sku->name,
            'num'           => $num,
            'tid'           => isset($data['tid']) ? $data['tid'] : 0,
            'note'          => isset($data['note']) ? $data['note'] : '',
            'use_time'      => isset($data['use_time']) ? $data['use_time'] : date('Y-m-d H:i:s', strtotime('+3 day')),
            'type'          => isset($data['type']) ? $data['type'] : 1
        ];


        if (isset($data['price']) && $data['price']) {
            $da['price'] = $da['price_unit'] = $data['price'];
        }

        $model->load($da, '');
        $model->save();

        return $model;
    }

    public static function createGoods($order, $goods, $data)
    {

        $type = isset($data['type']) ? $data['type'] : 1;
        $model = OrderRel::hasRel($order->id, $goods->id, 0, $order->user_id, $type);

        if (!$model) {
            $model = new OrderRel;
        }

        $num = isset($data['num']) && $data['num']>0 ? $data['num'] : 1;


        $title = $goods->name;

        $da = [
            'user_id'    => $order->user_id,
            'op_id'      => Yii::$app->user->id,
            'order_id'      => $order->id,
            'goods_id'      => $goods->id,
            'sku_id'        => 0,
            'category_id'   => $goods->category_id,
            'title'         => $title,
            'price_unit'    => $goods->price,
            'original_price'=> $num * $goods->price,
            'price'         => $num * $goods->price,
            'sku_name'      => '',
            'num'           => $num,
            'tid'           => isset($data['tid']) ? $data['tid'] : 0,
            'note'          => isset($data['note']) ? $data['note'] : '',
//            'use_time'      => isset($data['use_time']) ? $data['use_time'] : date('Y-m-d H:i:s', strtotime('+3 day')),
            'use_time'      => isset($data['use_time']) ? $data['use_time'] : null,
            'type'          => isset($data['type']) ? $data['type'] : 1
        ];


        if (isset($data['price']) && $data['price']) {
            $da['price'] = $da['price_unit'] = $data['price'];
        }

        $model->load($da, '');
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

    public static function hasRel($order_id, $goods_id, $sku_id, $user_id, $type=1)
    {

         return self::find()->where(['order_id'=>$order_id])
                             ->andWhere(['goods_id'=>$goods_id])
                             ->andWhere(['sku_id'=>$sku_id])
                             ->andWhere(['user_id'=> $user_id])
                             ->andWhere(['status'=>self::STATUS_NORMAL])
                             ->andWhere(['type'=>$type])
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
            'original_price' => '原价'
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

    public function getGoods()
    {
        return $this->hasOne(Goods::className(),['id'=>'goods_id']);
    }

    public function getTomb()
    {
        return $this->hasOne(Tomb::className(), ['id'=>'tid']);
    }

}
