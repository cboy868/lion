<?php

namespace app\modules\shop\models;

use Yii;

/**
 * This is the model class for table "{{%inventory}}".
 *
 * @property integer $id
 * @property integer $goods_id
 * @property integer $sku_id
 * @property double $record
 * @property double $actual
 * @property integer $op_id
 * @property string $op_date
 * @property double $diff_num
 * @property string $diff_amount
 * @property string $note
 * @property integer $created_at
 * @property integer $status
 */
class Inventory extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%inventory}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'sku_id', 'op_id', 'created_at', 'status'], 'integer'],
            [['record', 'actual', 'diff_num', 'diff_amount'], 'number'],
            [['op_date'], 'safe'],
            [['note'], 'string'],
            [['created_at'], 'required'],
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
            'sku_id' => 'SkuID',
            'record' => '记录',
            'actual' => '实数',
            'op_id' => '盘点人',
            'op_date' => '盘点时间',
            'diff_num' => '差额',
            'diff_amount' => '相差金额',
            'note' => '备注',
            'created_at' => '添加时间',
            'status' => 'Status',
        ];
    }
}
