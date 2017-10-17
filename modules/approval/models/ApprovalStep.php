<?php

namespace app\modules\approval\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%approval_step}}".
 *
 * @property integer $id
 * @property integer $approval_id
 * @property string $step_name
 * @property integer $step
 * @property string $approval_user
 * @property integer $progress
 * @property string $note
 * @property integer $created_at
 */
class ApprovalStep extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%approval_step}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['approval_id', 'step_name', 'step', 'approval_user', 'note'], 'required'],
            [['approval_id', 'step', 'progress', 'created_at'], 'integer'],
            [['note'], 'string'],
            [['step_name', 'approval_user'], 'string', 'max' => 255],
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
            'step_name' => '步骤名',
            'step' => '步',
            'approval_user' => '审批人',
            'progress' => '审批状态',
            'note' => '步骤',
            'created_at' => '添加时间',
        ];
    }

    public function getApproval()
    {
        return $this->hasOne(Approval::className(),['id' => 'approval_id']);
    }
}
