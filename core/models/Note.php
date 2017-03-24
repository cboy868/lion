<?php

namespace app\core\models;

use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "{{%shop_note}}".
 *
 * @property integer $id
 * @property integer $mid
 * @property string $intro
 * @property integer $user_id
 * @property string $end
 * @property integer $created_at
 * @property integer $status
 */
class Note extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%note}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'status', 'w_id'], 'integer'],
            [['intro', 'res_name'], 'string'],
            [['end', 'start'], 'safe'],
            [['intro'], 'required'],
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
            'intro' => '通知内容',
            'user_id' => '用户名',
            'end' => '显示截止时间',
            'start' => '显示开始时间',
            'created_at' => '添加时间',
            'status' => '状态',
        ];
    }

    /**
     * @name 保存前操作
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($insert) {
                $this->user_id = Yii::$app->user->id;
            }
            return true;
        } 

        return false;
    }
}
