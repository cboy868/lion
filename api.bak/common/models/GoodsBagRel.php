<?php

namespace api\common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%shop_bag_rel}}".
 *
 * @property integer $id
 * @property integer $bag_id
 * @property integer $sku_id
 * @property integer $num
 * @property string $unit_price
 * @property string $price
 * @property integer $status
 * @property integer $created_at
 */
class GoodsBagRel extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_bag_rel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bag_id', 'sku_id'], 'required'],
            [['bag_id', 'sku_id', 'num', 'status', 'created_at'], 'integer'],
            [['unit_price', 'price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bag_id' => 'Bag ID',
            'goods_id' => '商品id',
            'sku_id' => 'Sku ID',
            'num' => '数量',
            'unit_price' => '单价',
            'price' => 'Price',//暂时没用
            'status' => 'Status',
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
    
    public function getBag()
    {
        return $this->hasOne(Bag::className(),['id'=>'bag_id']);
    }

    public function getSku()
    {
        return $this->hasOne(Sku::className(),['id'=>'sku_id']);
    }
}
