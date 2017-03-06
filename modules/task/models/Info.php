<?php

namespace app\modules\task\models;

use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "{{%task_info}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property string $msg
 * @property integer $status
 * @property integer $created_at
 */
class Info extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_info}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['intro', 'msg'], 'string'],
            [['status', 'created_at'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 200],
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
            'name' => '任务名',
            'intro' => '介绍',
            'msg' => '消息内容',
            'status' => '状态',
            'created_at' => '添加时间',
        ];
    }

    public function getDefault()
    {
        return $this->hasOne(User::className(),['info_id'=>'id'])->where(['default'=>1]);

    }

    public function getUsers()
    {
        return $this->hasMany(User::className(),['info_id'=>'id']);
    }
}
