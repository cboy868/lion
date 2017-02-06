<?php

namespace app\modules\grave\models;

use Yii;

/**
 * This is the model class for table "{{%grave_portrait_log}}".
 *
 * @property integer $id
 * @property integer $portrait_id
 * @property integer $op_id
 * @property integer $tomb_id
 * @property string $action
 * @property string $img
 * @property string $note
 * @property integer $status
 * @property integer $updated_at
 * @property integer $created_at
 */
class PortraitLog extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_portrait_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['portrait_id', 'op_id', 'tomb_id', 'updated_at', 'created_at'], 'required'],
            [['portrait_id', 'op_id', 'tomb_id', 'status', 'updated_at', 'created_at'], 'integer'],
            [['note'], 'string'],
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
            'portrait_id' => 'Portrait ID',
            'op_id' => 'Op ID',
            'tomb_id' => 'Tomb ID',
            'action' => 'Action',
            'img' => 'Img',
            'note' => 'Note',
            'status' => 'Status',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }
}
