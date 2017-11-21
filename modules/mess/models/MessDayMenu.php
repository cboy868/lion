<?php

namespace app\modules\mess\models;

use Yii;
use yii\behaviors\TimestampBehavior;
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
            [['day_time', 'menu_id', 'real_price', 'type', 'mess_id'], 'required'],
            [['day_time'], 'safe'],
            [['menu_id', 'type', 'is_special', 'mess_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['real_price', 'check_price'], 'number'],
        ];
    }

    public function behaviors()
    {
        return [
                'class'=>TimestampBehavior::className(),
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
            'day_time' => '日期',
            'menu_id' => '菜单',
            'real_price' => '时价',
            'check_price' => '核算价',
            'type' => '类别',//早午晚
            'is_special' => 'Is Special',//0正常 1小炒
            'status' => '状态',
            'created_at' => '添加时间',
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

}
