<?php

namespace app\modules\approval\models;

use app\modules\user\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%approval}}".
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $process_id
 * @property string $title
 * @property string $total
 * @property string $yet_money
 * @property string $pay
 * @property string $intro
 * @property integer $progress
 * @property integer $nowstep
 * @property integer $status
 * @property string $create_user
 * @property integer $eng_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class Approval extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%approval}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'process_id', 'progress','create_user', 'nowstep', 'status', 'eng_id', 'created_at', 'updated_at'], 'integer'],
            [['process_id', 'title', 'intro', 'create_user'], 'required'],
            [['total', 'yet_money', 'pay'], 'number'],
            [['intro'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => 'Pid',
            'process_id' => '流程id',
            'title' => '审批标题',
            'total' => '总金额',
            'yet_money' => '已付金额',
            'pay' => '本次审批金额',
            'intro' => '内容',
            'progress' => '审批状态',
            'nowstep' => '目前步骤',
            'status' => '状态',
            'create_user' => '审批人',
            'eng_id' => '工程id',
            'created_at' => '担审时间',
            'updated_at' => '修改时间',
            'process.title' => '所属流程'
        ];
    }

    public function getProcess()
    {
        return $this->hasOne(ApprovalProcess::className(),['id' => 'process_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(),['id' => 'create_user']);
    }
}
