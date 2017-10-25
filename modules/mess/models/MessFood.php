<?php

namespace app\modules\mess\models;

use Yii;

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
            [['category_id', 'food_name', 'unit_id', 'created_at'], 'required'],
            [['category_id', 'unit_id', 'status', 'created_at'], 'integer'],
            [['food_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'food_name' => 'Food Name',
            'unit_id' => 'Unit ID',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}
