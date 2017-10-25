<?php

namespace app\modules\mess\models;

use Yii;

/**
 * This is the model class for table "{{%mess_day_menu}}".
 *
 * @property integer $id
 * @property string $day_time
 * @property integer $menu_id
 * @property string $real_price
 * @property string $check_price
 * @property integer $type
 * @property integer $is_special
 * @property integer $mess_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class MessDayMenu extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mess_day_menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['day_time', 'menu_id', 'real_price', 'check_price', 'type', 'mess_id', 'created_at', 'updated_at'], 'required'],
            [['day_time'], 'safe'],
            [['menu_id', 'type', 'is_special', 'mess_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['real_price', 'check_price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'day_time' => 'Day Time',
            'menu_id' => 'Menu ID',
            'real_price' => 'Real Price',
            'check_price' => 'Check Price',
            'type' => 'Type',
            'is_special' => 'Is Special',
            'mess_id' => 'Mess ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
