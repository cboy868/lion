<?php

namespace app\modules\mess\models;

use Yii;

/**
 * This is the model class for table "{{%mess_stock_log}}".
 *
 * @property integer $id
 * @property integer $mess_id
 * @property integer $food_id
 * @property double $num
 * @property string $unit_price
 * @property string $count_price
 * @property integer $created_at
 */
class MessStockLog extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mess_stock_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mess_id', 'food_id', 'unit_price', 'count_price', 'created_at'], 'required'],
            [['mess_id', 'food_id', 'created_at'], 'integer'],
            [['num', 'unit_price', 'count_price'], 'number'],
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
            'food_id' => 'Food ID',
            'num' => 'Num',
            'unit_price' => 'Unit Price',
            'count_price' => 'Count Price',
            'created_at' => 'Created At',
        ];
    }
}
