<?php

namespace app\modules\approval\models;

use app\modules\user\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%approval_process_step}}".
 *
 * @property integer $id
 * @property integer $process_id
 * @property string $step_name
 * @property integer $step
 * @property string $approval_user
 * @property integer $created_at
 */
class ApprovalProcessStep extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%approval_process_step}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['process_id', 'step', 'approval_user'], 'required'],
            [['process_id', 'step', 'created_at'], 'integer'],
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
            'process_id' => 'Process ID',
            'step_name' => '步骤名',
            'step' => '步',
            'approval_user' => '审批人',
            'created_at' => '添加时间',
        ];
    }

    public function getProcess()
    {
        return $this->hasOne(ApprovalProcess::className(),['id' => 'process_id']);
    }
    public function getApprovalUsers()
    {
        $ids = explode(',', $this->approval_user);
        $users = User::find()->where(['id'=>$ids,'status'=>User::STATUS_ACTIVE])->all();
        return $users;
    }
}
