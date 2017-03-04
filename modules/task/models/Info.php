<?php

namespace app\modules\task\models;

use Yii;

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
}
