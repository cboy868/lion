<?php

namespace app\modules\client\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%client_reception}}".
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $guide_id
 * @property integer $agent_id
 * @property string $car_number
 * @property integer $person_num
 * @property string $start
 * @property string $end
 * @property integer $un_reason
 * @property integer $is_success
 * @property string $note
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Reception extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%client_reception}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'guide_id', 'agent_id', 'person_num', 'un_reason', 'is_success', 'status', 'created_at', 'updated_at'], 'integer'],
            [['start', 'end'], 'required'],
            [['start', 'end'], 'safe'],
            [['note'], 'string'],
            [['car_number'], 'string', 'max' => 128],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'guide_id' => 'Guide ID',
            'agent_id' => 'Agent ID',
            'car_number' => 'Car Number',
            'person_num' => 'Person Num',
            'start' => 'Start',
            'end' => 'End',
            'un_reason' => 'Un Reason',
            'is_success' => 'Is Success',
            'note' => 'Note',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
