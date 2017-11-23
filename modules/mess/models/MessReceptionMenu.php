<?php

namespace app\modules\mess\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%mess_reception_menu}}".
 *
 * @property integer $id
 * @property integer $day_menu_id
 * @property integer $type
 * @property integer $reception_id
 * @property string $real_price
 * @property double $num
 * @property integer $status
 * @property integer $created_at
 */
class MessReceptionMenu extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mess_reception_menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['day_menu_id', 'type', 'reception_id', 'real_price', 'mess_id','day_time','menu_id'], 'required'],
            [['day_menu_id', 'type', 'reception_id', 'status', 'created_at', 'mess_id','menu_id'], 'integer'],
            [['real_price', 'num'], 'number'],
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
            'day_menu_id' => 'Day Menu ID',
            'type' => '类型',
            'reception_id' => '接待',
            'real_price' => '价格',
            'num' => '数量',
            'status' => '状态',
            'created_at' => '添加时间',
            'mess_id' => '食堂',
            'day_time' => '用餐时间'
        ];
    }

    public function getMess()
    {
        return $this->hasOne(Mess::className(), ['id'=>'mess_id']);
    }

    public function getMenu()
    {
        return $this->hasOne(MessMenu::className(), ['id'=>'menu_id']);
    }
}
