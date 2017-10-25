<?php

namespace app\modules\mess\models;

use Yii;

/**
 * This is the model class for table "{{%mess_day_menu_food}}".
 *
 * @property integer $id
 * @property integer $day_menu_id
 * @property integer $menu_id
 * @property integer $food_id
 * @property double $num
 * @property string $unit_price
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class MessDayMenuFood extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mess_day_menu_food}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['day_menu_id', 'menu_id', 'food_id', 'num', 'created_at', 'updated_at'], 'required'],
            [['day_menu_id', 'menu_id', 'food_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['num', 'unit_price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'day_menu_id' => 'Day Menu ID',
            'menu_id' => 'Menu ID',
            'food_id' => 'Food ID',
            'num' => 'Num',
            'unit_price' => 'Unit Price',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
