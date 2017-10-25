<?php

namespace app\modules\approval\models;

use app\modules\user\models\User;
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
    const PRO_BACK = -1;
    const PRO_INIT = 1;
    const PRO_OK = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%approval_step}}';
    }

    public static function pros($pro=null)
    {
        $p = [
            self::PRO_INIT => '待审批',
            self::PRO_BACK => '打回',
            self::PRO_OK => '审批通过'
        ];

        if ($pro!==null && isset($p[$pro])) {
            return $p[$pro];
        }

        return $p;
    }

    public function getPro()
    {
        return self::pros($this->progress);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['approval_id', 'step_name', 'step', 'approval_user'], 'required'],
            [['approval_id', 'step', 'progress', 'created_at', 'time'], 'integer'],
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
            'note' => '备注',
            'created_at' => '添加时间',
        ];
    }

    public function back()
    {
        $this->progress = self::PRO_BACK;
        $this->save();

        #1 把未审批的全部删除
        Yii::$app->db->createCommand()
            ->delete(ApprovalStep::tableName(),[
                'approval_id' => $this->approval_id,
                'progress' => 1,
            ])
            ->execute();

        #2 主记录改状态
        $model = Approval::findOne($this->approval_id);
        $model->progress = Approval::PRO_BACK;
        $model->nowstep = -1;
        $model->save();
    }

    public function pass()
    {
        $thisStep = self::find()->where(['<>', 'id', $this->id])
                                ->andWhere(['step'=>$this->step])
                                ->andWhere(['approval_id'=>$this->approval_id])
                                ->andWhere(['progress'=>1])
                                ->one();
        if ($thisStep) {
            return ;
        }

        $nextStep = $this->step + 1;
        $nextPro = ApprovalProcessStep::find()->where(['process_id'=>$this->approval->process->id])
                                            ->andWhere(['step'=>$nextStep])
                                            ->one();

        if (!$nextPro) {
            return $this->approval->pass($this->step);
            //不存在下一级，则整个流程直接通过
        }

        $this->approval->generateStep($nextStep);
        $this->approval->next();
    }

    public function getApproval()
    {
        return $this->hasOne(Approval::className(),['id' => 'approval_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id'=>'approval_user']);
    }
}
