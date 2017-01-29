<?php

namespace app\modules\grave\models;

use Yii;

/**
 * This is the model class for table "{{%grave_bury}}".
 *
 * @property integer $id
 * @property integer $tomb_id
 * @property integer $user_id
 * @property integer $dead_id
 * @property integer $dead_name
 * @property integer $dead_num
 * @property integer $bury_type
 * @property string $pre_bury_date
 * @property string $bury_date
 * @property string $bury_time
 * @property integer $bury_user
 * @property integer $bury_order
 * @property string $note
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class Bury extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_bury}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tomb_id', 'user_id', 'dead_id', 'dead_name', 'dead_num'], 'required'],
            [['tomb_id', 'user_id', 'dead_id', 'dead_name', 'dead_num', 'bury_type', 'bury_user', 'bury_order', 'created_at', 'updated_at', 'status'], 'integer'],
            [['pre_bury_date', 'bury_date', 'bury_time'], 'safe'],
            [['note'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tomb_id' => 'Tomb ID',
            'user_id' => 'User ID',
            'dead_id' => 'Dead ID',
            'dead_name' => 'Dead Name',
            'dead_num' => 'Dead Num',
            'bury_type' => 'Bury Type',
            'pre_bury_date' => 'Pre Bury Date',
            'bury_date' => 'Bury Date',
            'bury_time' => 'Bury Time',
            'bury_user' => 'Bury User',
            'bury_order' => 'Bury Order',
            'note' => 'Note',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
