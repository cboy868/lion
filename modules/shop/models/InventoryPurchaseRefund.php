<?php

namespace app\modules\shop\models;

use Yii;

/**
 * This is the model class for table "{{%inventory_purchase_refund}}".
 *
 * @property integer $id
 * @property integer $purchase_rel_id
 * @property double $num
 * @property string $amount
 * @property integer $op_id
 * @property string $op_name
 * @property string $ct_name
 * @property string $ct_mobile
 * @property string $note
 * @property integer $created_at
 * @property integer $status
 */
class InventoryPurchaseRefund extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%inventory_purchase_refund}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['purchase_rel_id', 'op_id', 'created_at', 'status'], 'integer'],
            [['num', 'amount'], 'number'],
            [['note'], 'string'],
            [['created_at'], 'required'],
            [['op_name', 'ct_name'], 'string', 'max' => 255],
            [['ct_mobile'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'purchase_rel_id' => '进货明细id',
            'num' => '退货数量',
            'amount' => '退货金额',
            'op_id' => '操作人',
            'op_name' => '操作人',
            'ct_name' => '联系人',
            'ct_mobile' => '联系电话',
            'note' => '备注',
            'created_at' => '添加时间',
            'status' => '状态',
        ];
    }
}
