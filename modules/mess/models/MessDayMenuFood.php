<?php

namespace app\modules\mess\models;

use Yii;
use yii\behaviors\TimestampBehavior;
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
            [['day_menu_id', 'menu_id', 'food_id', 'num'], 'required'],
            [['day_menu_id', 'menu_id', 'food_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['num', 'unit_price'], 'number'],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at']
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'day_menu_id' => '菜单',
            'menu_id' => '菜单',
            'food_id' => '原料',
            'num' => '数量',
            'unit_price' => '单价',
            'status' => '状态',
            'created_at' => '添加时间',
            'updated_at' => 'Updated At',
        ];
    }
}
