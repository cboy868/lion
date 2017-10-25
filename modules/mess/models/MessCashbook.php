<?php

namespace app\modules\mess\models;

use Yii;

/**
 * This is the model class for table "{{%mess_cashbook}}".
 *
 * @property integer $id
 * @property integer $mess_id
 * @property string $note
 * @property string $unit_price
 * @property string $count_price
 * @property integer $type
 * @property integer $op_id
 * @property integer $created_at
 * @property integer $status
 */
class MessCashbook extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mess_cashbook}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mess_id', 'note', 'unit_price', 'count_price', 'type', 'op_id', 'created_at', 'status'], 'required'],
            [['mess_id', 'type', 'op_id', 'created_at', 'status'], 'integer'],
            [['unit_price', 'count_price'], 'number'],
            [['note'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mess_id' => 'Mess ID',
            'note' => 'Note',
            'unit_price' => 'Unit Price',
            'count_price' => 'Count Price',
            'type' => 'Type',
            'op_id' => 'Op ID',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }
}
