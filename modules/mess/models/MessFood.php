<?php

namespace app\modules\mess\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%mess_food}}".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $food_name
 * @property integer $unit_id
 * @property integer $status
 * @property integer $created_at
 */
class MessFood extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mess_food}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'food_name'], 'required'],
            [['category_id', 'unit_id', 'status', 'created_at'], 'integer'],
            [['food_name'], 'string', 'max' => 50],
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
            'category_id' => '分类',
            'food_name' => '食材名',
            'unit_id' => '单位',
            'status' => 'Status',
            'created_at' => '添加时间',
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(MessFoodCategory::className(), ['id'=>'category_id']);
    }
}
