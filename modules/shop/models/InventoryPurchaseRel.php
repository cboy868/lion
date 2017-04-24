<?php

namespace app\modules\shop\models;

use Yii;

/**
 * This is the model class for table "{{%inventory_purchase_rel}}".
 *
 * @property integer $id
 * @property integer $supplier_id
 * @property integer $record_id
 * @property integer $goods_id
 * @property integer $sku_id
 * @property string $unit_price
 * @property double $num
 * @property string $unit
 * @property string $total
 * @property string $retail
 * @property integer $op_id
 * @property string $op_name
 * @property string $note
 * @property integer $created_at
 * @property integer $status
 */
class InventoryPurchaseRel extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%inventory_purchase_rel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supplier_id', 'record_id', 'goods_id', 'sku_id', 'created_at'], 'required'],
            [['supplier_id', 'record_id', 'goods_id', 'sku_id', 'op_id', 'created_at', 'status'], 'integer'],
            [['unit_price', 'num', 'total', 'retail'], 'number'],
            [['note'], 'string'],
            [['unit'], 'string', 'max' => 20],
            [['op_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'supplier_id' => '供货商',
            'record_id' => '进货批次id',
            'goods_id' => '商品id',
            'sku_id' => 'Sku ID',
            'unit_price' => '单价',
            'num' => '数量',
            'unit' => '单位',
            'total' => '总价',
            'retail' => '建议零售价',
            'op_id' => '操作人',
            'op_name' => '操作人',
            'note' => '备注',
            'created_at' => '添加时间',
            'status' => '状态',
        ];
    }
}
