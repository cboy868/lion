<?php

namespace app\modules\grave\models;

use Yii;

/**
 * This is the model class for table "{{%grave_ins_log}}".
 *
 * @property integer $id
 * @property integer $ins_id
 * @property integer $op_id
 * @property integer $tomb_id
 * @property string $action
 * @property string $img
 * @property string $content
 * @property integer $status
 * @property integer $updated_at
 * @property integer $created_at
 */
class InsLog extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_ins_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ins_id', 'op_id', 'tomb_id', 'updated_at', 'created_at'], 'required'],
            [['ins_id', 'op_id', 'tomb_id', 'status', 'updated_at', 'created_at'], 'integer'],
            [['content'], 'string'],
            [['action'], 'string', 'max' => 100],
            [['img'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ins_id' => 'Ins ID',
            'op_id' => 'Op ID',
            'tomb_id' => 'Tomb ID',
            'action' => 'Action',
            'img' => 'Img',
            'content' => 'Content',
            'status' => 'Status',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }
}
