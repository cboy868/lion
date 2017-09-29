<?php

namespace app\modules\shop\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%inventory_storage_rel}}".
 *
 * @property integer $id
 * @property integer $storage_id
 * @property integer $goods_id
 * @property integer $sku_id
 * @property integer $total
 * @property string $note
 * @property integer $created_at
 */
class InventoryStorageRel extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%inventory_storage_rel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['storage_id', 'goods_id', 'sku_id'], 'required'],
            [['storage_id', 'goods_id', 'sku_id', 'total', 'created_at', 'status'], 'integer'],
            [['note'], 'string'],
        ];
    }
    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    InventorySupplier::EVENT_BEFORE_INSERT => ['created_at'],
                ],
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
            'storage_id' => '仓库',
            'goods_id' => '商品',
            'sku_id' => 'Sku',
            'total' => '总数量',
            'note' => '备注',
            'created_at' => '添加时间',
        ];
    }

    /**
     * @name 添加库存，如果没有记录，则添加记录
     */
    public static function add()
    {

    }

    public function getGoods()
    {
        return $this->hasOne(Goods::className(), ['id'=>'goods_id']);
    }

    public function getSku()
    {
        return $this->hasOne(Sku::className(), ['id'=>'sku_id']);
    }

    public function getStorage()
    {
        return $this->hasOne(InventoryStorage::className(), ['id'=>'storage_id']);
    }
}
