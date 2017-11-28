<?php

namespace app\modules\mess\models;

use Yii;

/**
 * This is the model class for table "{{%mess_menu_food}}".
 *
 * @property integer $id
 * @property integer $menu_id
 * @property integer $food_id
 * @property double $num
 */
class MessMenuFood extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mess_menu_food}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'food_id', 'num'], 'required'],
            [['menu_id', 'food_id'], 'integer'],
            [['num'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu_id' => '菜单',
            'food_id' => '食材',
            'num' => '数量',
        ];
    }


    public function getFood()
    {
        return $this->hasOne(MessFood::className(), ['id'=>'food_id']);
    }
}
