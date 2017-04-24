<?php

namespace app\modules\shop\models;

use Yii;

/**
 * This is the model class for table "{{%inventory_purchase_finance}}".
 *
 * @property integer $id
 * @property integer $purchase_id
 * @property integer $refund_id
 * @property string $amount
 * @property integer $op_id
 * @property string $op_name
 * @property string $ct_name
 * @property string $ct_mobile
 * @property string $note
 * @property integer $created_at
 * @property integer $status
 */
class InventoryPurchaseFinance extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%inventory_purchase_finance}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['purchase_id', 'refund_id', 'op_id', 'created_at', 'status'], 'integer'],
            [['amount'], 'number'],
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
            'purchase_id' => '进货记录',
            'refund_id' => '退货记录',
            'amount' => '总金额',
            'op_id' => '操作人id',
            'op_name' => '操作人',
            'ct_name' => '联系人',
            'ct_mobile' => '联系人电话',
            'note' => '备注',
            'created_at' => '添加时间',
            'status' => '状态',
        ];
    }
}
