<?php

namespace app\modules\shop\models;

use Yii;
use yii\behaviors\TimestampBehavior;
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
            [['price'], 'number'],
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
            'name' => '规格名',
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
}
