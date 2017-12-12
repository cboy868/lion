<?php

namespace app\modules\approval\models;

use Yii;
use yii\base\Model;
use yii\web\NotFoundHttpException;

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
class ApprovalAdjustForm extends Model
{
    public $start;
    public $end;
    public $hours;
    public $type;
    public $desc;
    public $genre;
    public $overtime_ids;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['start', 'end','hours'], 'required'],
            [['hours','type', 'genre'], 'number'],
            [['desc'], 'string'],
            ['overtime_ids', 'safe']
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
            'overtime_ids' => '加班记录'
        ];
    }

    public function create()
    {
        $model = new ApprovalLeave();
        $start = explode(' ', $this->start);
        $end = explode(' ', $this->end);
        $post = Yii::$app->request->post();

        if ($this->load($post) && $this->validate()) {
            $model->start_day = $start[0];
            $model->start_time = $start[1];
            $model->end_day = $end[0];
            $model->end_time = $end[1];
            $model->created_by = Yii::$app->user->id;
            $model->created_dtime = date('Y-m-d H:i:s');
            $model->year = date('Y', strtotime($this->start));
            $model->hours = $this->hours;
            $model->type = 0;
            $model->desc = $this->desc;
            $model->genre = $this->genre;
            $model->month = date('m', strtotime($model->start_day));
            $model->overtime_ids = implode(',', $this->overtime_ids);

            if ($model->save()) {
                return $model;
            } else {
                throw new NotFoundHttpException('数据出错');
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
            $leave->type = 0;
            $leave->desc = $this->desc;
            $leave->month = date('m', strtotime($leave->start_day));
            $leave->status = ApprovalLeave::STATUS_NORMAL;

            if ($leave->save()) {
                return $leave;
            } else {
                return false;
            }
        }
    }
}
