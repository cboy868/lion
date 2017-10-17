<?php

namespace app\modules\approval\models;

use app\core\helpers\ArrayHelper;
use app\modules\user\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%approval_process}}".
 *
 * @property integer $id
 * @property integer $eng_id
 * @property string $title
 * @property string $intro
 * @property string $can_user
 * @property integer $step_total
 * @property integer $create_user
 * @property integer $created_at
 * @property integer $status
 */
class ApprovalProcess extends \app\core\db\ActiveRecord
{

    const TYPE_RICHANG = 1;
    const TYPE_LEAVE = 2;
    const TYPE_ENG = 3;
    const TYPE_CAM = 4;
    const TYPE_GOODS = 5;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%approval_process}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['eng_id', 'step_total', 'create_user', 'created_at', 'status','type'], 'integer'],
            [['title', 'intro', 'can_user', 'step_total', 'create_user'], 'required'],
            [['intro'], 'string'],
            [['title', 'can_user'], 'string', 'max' => 255],
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
            'eng_id' => 'Eng ID',
            'title' => '标题',
            'intro' => '内容',
            'can_user' => '可发起人',
            'step_total' => '审批步数',
            'create_user' => '添加人',
            'created_at' => '添加时间',
            'status' => '状态',
            'type' => '类型',
            'user.username' => '创建人',

        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(),['id' => 'create_user']);
    }

    public function getCans()
    {
        return $this->hasMany(ApprovalCan::className(), ['process_id'=>'id']);
    }

    public function getSteps()
    {
        return $this->hasMany(ApprovalProcessStep::className(), ['process_id'=>'id']);
    }

    public static function process($self=true)
    {

        $query = self::find()->where(['status'=>self::STATUS_NORMAL]);
        if ($self) { //个人可以发起的审批
            $cans = ApprovalCan::find()->where(['user_id'=>Yii::$app->user->id])->asArray()->all();
            $process_ids = \yii\helpers\ArrayHelper::getColumn($cans, 'process_id');
            $query->andWhere(['id'=>$process_ids]);
        }
        $all = $query->all();
        return $all;
        p($all);die;

        return ArrayHelper::map($all, 'id', 'title');
    }
}
