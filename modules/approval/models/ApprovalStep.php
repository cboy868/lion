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
            self::PRO_INIT => '初始',
            self::PRO_BACK => '打回',
            self::PRO_OK => '通过'
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

    public function getApproval()
    {
        return $this->hasOne(Approval::className(),['id' => 'approval_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id'=>'approval_user']);
    }
}
