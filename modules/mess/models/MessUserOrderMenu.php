<?php

namespace app\modules\mess\models;

use app\modules\user\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;

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
            [['mess_id', 'user_id', 'day_menu_id', 'real_price'], 'required'],
            [['mess_id', 'user_id', 'day_menu_id', 'menu_id', 'type', 'is_pre',
                'is_over', 'is_mobile', 'created_at', 'updated_at'], 'integer'],
            [['day_time'], 'safe'],
            [['real_price', 'num'], 'number'],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
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
            'mess_id' => 'Mess ID',
            'user_id' => 'User ID',
            'day_menu_id' => 'Day Menu ID',
            'menu_id' => '菜单',
            'day_time' => '日期',
            'real_price' => '时价',
            'num' => '数量',
            'type' => '类型',
            'is_pre' => 'Is Pre',
            'is_over' => 'Is Over',
            'is_mobile' => 'Is Mobile',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getMenu()
    {
        return $this->hasOne(MessMenu::className(), ['id'=>'menu_id']);
    }

    public function getMess()
    {
        return $this->hasOne(Mess::className(), ['id'=>'mess_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id'=>'user_id']);
    }

    public function getDayMenu()
    {
        return $this->hasOne(MessDayMenu::className(), ['id'=>'day_menu_id']);
    }
}
