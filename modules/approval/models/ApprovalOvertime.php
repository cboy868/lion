<?php

namespace app\modules\approval\models;

use Yii;

/**
 * This is the model class for table "{{%approval_overtime}}".
 *
 * @property string $id
 * @property integer $approval_id
 * @property string $year
 * @property string $start_day
 * @property string $end_day
 * @property string $start_time
 * @property string $end_time
 * @property double $hours
 * @property string $leave
 * @property string $type
 * @property string $desc
 * @property integer $status
 * @property string $reason
 * @property integer $created_by
 * @property string $created_date
 * @property integer $reviewed_by
 * @property string $reviewed_date
 */
class ApprovalOvertime extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%approval_overtime}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['approval_id', 'status', 'created_by', 'reviewed_by'], 'integer'],
            [['year', 'start_day', 'end_day', 'start_time', 'end_time', 'leave', 'desc', 'reason', 'created_by', 'created_date', 'reviewed_by', 'reviewed_date'], 'required'],
            [['start_day', 'end_day', 'start_time', 'end_time', 'created_date', 'reviewed_date'], 'safe'],
            [['hours'], 'number'],
            [['desc'], 'string'],
            [['year'], 'string', 'max' => 4],
            [['leave'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 50],
            [['reason'], 'string', 'max' => 250],
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
            'year' => 'Year',
            'start_day' => 'Start Day',
            'end_day' => 'End Day',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'hours' => 'Hours',
            'leave' => 'Leave',
            'type' => 'Type',
            'desc' => 'Desc',
            'status' => 'Status',
            'reason' => 'Reason',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'reviewed_by' => 'Reviewed By',
            'reviewed_date' => 'Reviewed Date',
        ];
    }
}
