<?php

namespace app\modules\shop\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\order\models\Order;
/**
 * This is the model class for table "{{%shop_sku}}".
 *
 * @property integer $id
 * @property integer $goods_id
 * @property integer $num
 * @property string $price
 * @property string $name
 * @property string $av
 * @property integer $created_at
 */

// $sku = Sku::findOne(38);
// $a = $sku->order(['order_note'=> '最新订单', 'note'=>'note记录', 'use_time'=>'2016-02-02 22:12:00', 'num'=>12]);
class Sku extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_sku}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id'], 'required'],
            [['goods_id', 'num', 'created_at'], 'integer'],
            [['price', 'original_price'], 'number'],
            [['name', 'av'], 'string', 'max' => 255],
            [['serial'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => '商品id',
            'num' => '数量',
            'price' => '价格',
            'original_price' => '原价',
            'name' => '名称',
            'av' => '规格',
            'serial' => '序列号',
            'created_at' => 'Created At',
        ];
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

    public function getGoods()
    {
        return $this->hasOne(Goods::className(),['id'=>'goods_id']);
    }

    /**
     * @name 下订单
     */
    public function order($user_id, $extra, $res_name='', $res_id=0)
    {
        return Order::create($user_id, $this, $extra, $res_name, $res_id);
    }

    public function getName()
    {

        return $this->name == $this->goods->name ? $this->name : $this->goods->name . $this->name;
    }

    // public function skuOrder($user_id, $extra=[])
    // {
    //     return Order::createOrder($user_id, $this, $extra);
    // }


}
