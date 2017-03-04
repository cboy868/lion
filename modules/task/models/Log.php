<?php

namespace app\modules\task\models;

use Yii;

/**
 * This is the model class for table "{{%task_log}}".
 *
 * @property integer $id
 * @property integer $task_id
 * @property integer $user_id
 * @property string $action
 * @property string $conent
 * @property integer $created_at
 */
class Log extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id', 'user_id', 'created_at'], 'integer'],
            [['conent'], 'string'],
            [['created_at'], 'required'],
            [['action'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'user_id' => 'User ID',
            'action' => 'Action',
            'conent' => 'Conent',
            'created_at' => 'Created At',
        ];
    }
}
