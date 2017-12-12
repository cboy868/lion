<?php

namespace app\modules\approval\models;

use app\modules\user\models\User;
use Yii;

/**
 * This is the model class for table "{{%approval_leave}}".
 *
 * @property string $id
 * @property string $approval_id
 * @property string $year
 * @property string $start_day
 * @property string $end_day
 * @property string $start_time
 * @property string $end_time
 * @property double $hours
 * @property string finish_at
 * @property string $type
 * @property string $desc
 * @property string $status
 * @property string $created_by
 * @property string $created_dtime
 * @property string $reviewed_by
 * @property string $reviewed_dtime
 */
class ApprovalLeave extends \app\core\db\ActiveRecord
{
    const STATUS_DRAFT = 3;//草稿
    const STATUS_PASS  = 2;//通过
    const STATUS_REFUSE = 4;//拒绝

    const STATUS_ADJUST = 9;//已调休 加班的一种状态

    const GENRE_LEAVE = 1;//请假
    const GENRE_OVERTIME = 2;//加班
    const GENRE_ADJUST = 3;//调休
    const GENRE_OUT = 4; //外出
    const GENRE_TRIP = 5;//出差

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
            [['start_day', 'end_day', 'start_time', 'end_time','hours'], 'required'],
            [['id', 'approval_id','created_by','reviewed_by', 'month','type', 'status', 'genre'], 'integer'],
            [['start_day', 'end_day', 'start_time', 'end_time', 'finish_at',
                'created_dtime', 'reviewed_dtime'], 'safe'],
            [['hours'], 'number'],
            [['desc', 'reason', 'overtime_ids'], 'string'],
            [['year'], 'string', 'max' => 4]
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
            'year' => '年份',
            'month'=> '月份',
            'start_day' => '开始日期',
            'end_day' => '结束日期',
            'start_time' => '开始时间',
            'end_time' => '结束时间',
            'hours' => '总时长',
            'finish_at' => '报到时间',
            'type' => '请假类型',
            'desc' => '请假事由',
            'status' => '请假状态',
            'created_by' => '申请人',
            'created_dtime' => '创建时间',
            'reviewed_by' => '审批人',
            'reviewed_dtime' => '审批时间',
            'typeLabel' => '请假类型',
            'reason' => '拒绝原因'
        ];
    }

    /**
     * @name 请假类型
     */
    public function getTypeLabel()
    {
        $module = Yii::$app->getModule('approval');
        switch ($this->genre) {
            case ApprovalLeave::GENRE_LEAVE:
                $types = $module->params['leave_type'];
                break;
            case ApprovalLeave::GENRE_OVERTIME:
                $types = $module->params['overtime_type'];
                break;
        }

        return isset($types[$this->type]) ? $types[$this->type] : '';
    }

    public static function status($status=null)
    {
        $st = [
            self::STATUS_NORMAL => '待审核',
            self::STATUS_PASS => '审核通过',
            self::STATUS_DRAFT => '草稿',
            self::STATUS_REFUSE => '拒绝'
        ];

        if ($status === null) {
            return $st;
        }

        return isset($st[$status]) ? $st[$status] : '';
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id'=>'created_by']);
    }

    public function getOp()
    {
        return $this->hasOne(User::className(), ['id'=>'reviewed_by']);
    }

}
