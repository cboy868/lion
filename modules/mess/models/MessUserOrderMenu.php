<?php

namespace app\modules\mess\models;

use Yii;

/**
 * This is the model class for table "{{%mess_user_order_menu}}".
 *
 * @property integer $id
 * @property integer $mess_id
 * @property integer $user_id
 * @property integer $day_menu_id
 * @property integer $menu_id
 * @property string $day_time
 * @property string $real_price
 * @property double $num
 * @property integer $type
 * @property integer $is_pre
 * @property integer $is_over
 * @property integer $is_mobile
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class MessUserOrderMenu extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mess_user_order_menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mess_id', 'user_id', 'day_menu_id', 'real_price', 'created_at', 'updated_at'], 'required'],
            [['mess_id', 'user_id', 'day_menu_id', 'menu_id', 'type', 'is_pre', 'is_over', 'is_mobile', 'status', 'created_at', 'updated_at'], 'integer'],
            [['day_time'], 'safe'],
            [['real_price', 'num'], 'number'],
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
            'user_id' => 'User ID',
            'day_menu_id' => 'Day Menu ID',
            'menu_id' => 'Menu ID',
            'day_time' => 'Day Time',
            'real_price' => 'Real Price',
            'num' => 'Num',
            'type' => 'Type',
            'is_pre' => 'Is Pre',
            'is_over' => 'Is Over',
            'is_mobile' => 'Is Mobile',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
