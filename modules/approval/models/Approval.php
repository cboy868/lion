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
//-1打回，1未开始2审批中3审批完成4报销部分5报销完成6完成
    const PRO_BACK = -1;
    const PRO_INIT = 1;
    const PRO_ING = 2;
    const PRO_OK =3;
//    const PRO_CAM_PART = 4;
//    const PRO_CAM = 5;
//    const PRO_FINISH = 6;



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%approval}}';
    }

    public static function pros($pro = null)
    {
        $p = [
            self::PRO_BACK => '打回',
//            self::PRO_INIT => '初始化',
            self::PRO_ING => '审批中',
//            self::PRO_INIT => '审批中',
            self::PRO_OK => '审批完成',
//            self::PRO_CAM_PART => '报销部分',
//            self::PRO_CAM=> '报销完成',
//            self::PRO_FINISH => '完成'
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
            [['pid', 'process_id', 'progress','create_user', 'nowstep',
                'status', 'eng_id', 'created_at', 'updated_at', 'time'], 'integer'],
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
            'create_user' => '创建人',
            'user.username'=>'创建人',
            'eng_id' => '工程id',
            'created_at' => '担审时间',
            'updated_at' => '修改时间',
            'process.title' => '所属流程',
            'time' => '审批次数'
        ];
    }

    /**
     * @name 生成step
     */
    public function generateStep($step=1)
    {

        $pro_step = ApprovalProcessStep::find()
            ->where(['process_id'=>$this->process_id])
            ->andWhere(['step'=>$step])
            ->asArray()
            ->one();

        if (!$pro_step) {
            return ;
        }

        $astep = new ApprovalStep();
        $astep->approval_id = $this->id;
        $astep->progress = ApprovalStep::PRO_INIT;

        $time = ApprovalStep::find()->where(['approval_id'=>$this->id,'step'=>$step])->max('time');
        $time = $time+1;


        if (strpos($pro_step['approval_user'], ',')) {
            $sp = explode(',', $pro_step['approval_user']);
            foreach ($sp as $v) {
                $model = clone $astep;
                $model->step = $pro_step['step'];
                $model->step_name = $pro_step['step_name'];
                $model->approval_user = $v;
                $model->time = $time;
                $model->save();
            }
        } else {
            $model = clone $astep;
            $model->step = $pro_step['step'];
            $model->step_name = $pro_step['step_name'];
            $model->approval_user = $pro_step['approval_user'];
            $model->time = $time;
            $model->save();
        }
    }

    public function next()
    {
        $this->nowstep = $this->nowstep + 1;
        return $this->save();
    }

    public function pass($step)
    {
        $this->nowstep = $step;
        $this->progress = self::PRO_OK;
        return $this->save();
    }

    public function getProcess()
    {
        return $this->hasOne(ApprovalProcess::className(),['id' => 'process_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(),['id' => 'create_user']);
    }

    public function getSteps()
    {
        return $this->hasMany(ApprovalStep::className(), ['approval_id'=>'id'])->orderBy('time asc');
    }

    public function getAttachs()
    {
        return $this->hasMany(ApprovalAttach::className(), ['approval_id'=>'id'])
            ->andWhere(['status'=>ApprovalAttach::STATUS_NORMAL]);
    }
}
