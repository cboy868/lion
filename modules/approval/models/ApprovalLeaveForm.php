<?php

namespace app\modules\approval\models;

use Yii;
use yii\base\Model;

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
 * @property string $back_at
 * @property string $type
 * @property string $desc
 * @property string $status
 * @property string $created_by
 * @property string $created_dtime
 * @property string $reviewed_by
 * @property string $reviewed_dtime
 */
class ApprovalLeaveForm extends Model
{
    public $start;
    public $end;
    public $hours;
    public $type;
    public $desc;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['start', 'end','hours','type'], 'required'],
            [['hours','type'], 'number'],
            [['desc'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'start' => '开始',
            'end' => '结束',
            'hours' => '总时长',
            'type' => '请假类型',
            'desc' => '请假事由',
            'status' => '请假状态',
        ];
    }

    public function create()
    {
        $model = new ApprovalLeave();
        $start = explode(' ', $this->start);
        $end = explode(' ', $this->end);

        if ($this->load(Yii::$app->request->post()) && $this->validate()) {
            $model->start_day = $start[0];
            $model->start_time = $start[1];
            $model->end_day = $end[0];
            $model->end_time = $end[1];
            $model->created_by = Yii::$app->user->id;
            $model->created_dtime = date('Y-m-d H:i:s');
            $model->year = date('Y', strtotime($this->start));
            $model->hours = $this->hours;
            $model->type = $this->type;
            $model->desc = $this->desc;
            $model->month = date('m', strtotime($model->start_day));

            if ($model->save()) {
                return $model;
            } else {
                return false;
            }
        }
    }

    public function update($leave)
    {
        $start = explode(' ', $this->start);
        $end = explode(' ', $this->end);

        if ($this->load(Yii::$app->request->post()) && $this->validate()) {
            $leave->start_day = $start[0];
            $leave->start_time = $start[1];
            $leave->end_day = $end[0];
            $leave->end_time = $end[1];
            $leave->year = date('Y', strtotime($this->start));
            $leave->hours = $this->hours;
            $leave->type = $this->type;
            $leave->desc = $this->desc;
            $leave->month = date('m', strtotime($leave->start_day));

            if ($leave->save()) {
                return $leave;
            } else {
                return false;
            }
        }
    }
}
