<?php

namespace app\modules\shop\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%inventory_purchase}}".
 *
 * @property integer $id
 * @property integer $supplier_id
 * @property integer $op_id
 * @property string $op_name
 * @property string $ct_name
 * @property string $ct_mobile
 * @property integer $checker_id
 * @property string $checker_name
 * @property string $total
 * @property string $note
 * @property integer $created_at
 * @property integer $status
 */
class InventoryPurchase extends \app\core\db\ActiveRecord
{
    const STATUS_REFUND = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%inventory_purchase}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supplier_id', 'op_id', 'checker_id', 'status'], 'integer'],
            [['total'], 'number'],
            [['note', 'supply_at'], 'string'],
            [['supplier_id'], 'required'],
            [['op_name', 'ct_name', 'checker_name'], 'string', 'max' => 100],
            [['ct_mobile'], 'string', 'max' => 15],
        ];
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    InventoryPurchase::EVENT_BEFORE_INSERT => ['created_at'],
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
            'supplier_id' => '供货商',
            'op_id' => '操作人id',
            'op_name' => '操作人',
            'ct_name' => '联系人',
            'ct_mobile' => '联系电话',
            'checker_id' => '验收人',
            'checker_name' => '验收人',
            'total' => '总金额',
            'note' => '备注',
            'supply_at' => '进货时间',
            'status' => '状态',
        ];
    }

    public function getSupplier()
    {
        return $this->hasOne(InventorySupplier::className(), ['id'=>'supplier_id']);
    }

    public function getRels()
    {
        return $this->hasMany(InventoryPurchaseRel::className(), ['record_id'=>'id'])->where(['status'=>self::STATUS_NORMAL]);
    }
}
