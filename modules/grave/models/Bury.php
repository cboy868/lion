<?php

namespace app\modules\grave\models;

use Yii;
use yii\behaviors\TimestampBehavior;

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

    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
            ]
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tomb_id', 'user_id', 'dead_num', 'pre_bury_date'], 'required'],
            [['dead_id', 'dead_name'], 'required', 'message'=> '请选择使用人'],

            [['tomb_id', 'user_id', 'dead_num', 'bury_type', 'bury_user', 'bury_order', 'created_at', 'updated_at', 'status'], 'integer'],
            [['pre_bury_date', 'bury_date', 'bury_time'], 'safe'],
            [['note', 'dead_id','dead_name'], 'string'],
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
            'pre_bury_date' => '安葬日期',
            'bury_date' => '实际安葬日期',
            'bury_time' => '安葬时间',
            'bury_user' => 'Bury User',
            'bury_order' => 'Bury Order',
            'note' => 'Note',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
