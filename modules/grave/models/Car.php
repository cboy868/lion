<?php

namespace app\modules\grave\models;

use Yii;

/**
 * This is the model class for table "{{%grave_car}}".
 *
 * @property integer $id
 * @property string $code
 * @property integer $type
 * @property integer $keeper
 * @property string $note
 * @property integer $status
 * @property integer $created_at
 */
class Car extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_car}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'keeper', 'status', 'created_at'], 'integer'],
            [['note'], 'string'],
            [['created_at'], 'required'],
            [['code'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'type' => 'Type',
            'keeper' => 'Keeper',
            'note' => 'Note',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}
