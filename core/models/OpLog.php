<?php

namespace app\core\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%op_log}}".
 *
 * @property integer $id
 * @property string $route
 * @property string $description
 * @property integer $created_at
 * @property integer $user_id
 */
class OpLog extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%op_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description','table_name'], 'string'],
            [['description','table_name'], 'required'],
            [['created_at', 'user_id'], 'integer'],
            [['route'], 'string', 'max' => 255],
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
            'route' => 'Route',
            'description' => 'Description',
            'created_at' => 'Created At',
            'user_id' => 'User ID',
        ];
    }
}
