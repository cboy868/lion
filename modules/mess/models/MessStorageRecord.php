<?php

namespace app\modules\mess\models;

use Yii;

/**
 * This is the model class for table "{{%mess_storage_record}}".
 *
 * @property integer $id
 * @property integer $supplier_id
 * @property integer $mess_id
 * @property integer $food_id
 * @property double $number
 * @property string $unit_price
 * @property string $count_price
 * @property integer $type
 * @property integer $created_at
 */
class MessStorageRecord extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mess_storage_record}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supplier_id', 'mess_id', 'food_id', 'type', 'created_at'], 'integer'],
            [['mess_id', 'food_id', 'unit_price', 'count_price', 'type', 'created_at'], 'required'],
            [['number', 'unit_price', 'count_price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'supplier_id' => 'Supplier ID',
            'mess_id' => 'Mess ID',
            'food_id' => 'Food ID',
            'number' => 'Number',
            'unit_price' => 'Unit Price',
            'count_price' => 'Count Price',
            'type' => 'Type',
            'created_at' => 'Created At',
        ];
    }
}
