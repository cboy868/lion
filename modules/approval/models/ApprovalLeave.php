<?php

namespace app\modules\approval\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%approval_leave}}".
 *
 * @property integer $id
 * @property integer $approval_id
 * @property string $start_time
 * @property string $end_time
 * @property string $note
 * @property integer $created_at
 * @property integer $status
 */
class ApprovalLeave extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%approval_leave}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['approval_id', 'note'], 'required'],
            [['approval_id', 'created_at', 'status'], 'integer'],
            [['start_time', 'end_time'], 'safe'],
            [['note'], 'string'],
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
            'approval_id' => 'Approval ID',
            'start_time' => '开始',
            'end_time' => '结束',
            'note' => '备注',
            'created_at' => '添加时间',
            'status' => '状态',
        ];
    }

    public function getApproval()
    {
        return $this->hasOne(Approval::className(),['id' => 'approval_id']);
    }
}
