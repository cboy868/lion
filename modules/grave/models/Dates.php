<?php

namespace app\modules\grave\models;

use Yii;

/**
 * This is the model class for table "{{%grave_dead_dates}}".
 *
 * @property integer $id
 * @property integer $tomb_id
 * @property integer $dead_id
 * @property string $title
 * @property string $dead_name
 * @property string $solar_dt
 * @property string $lunar_dt
 * @property string $time
 * @property string $intro
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class Dates extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_dead_dates}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tomb_id', 'dead_name'], 'required'],
            [['tomb_id', 'dead_id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['solar_dt', 'time'], 'safe'],
            [['intro'], 'string'],
            [['title'], 'string', 'max' => 200],
            [['dead_name'], 'string', 'max' => 255],
            [['lunar_dt'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tomb_id' => 'Tomb ID',
            'dead_id' => 'Dead ID',
            'title' => 'Title',
            'dead_name' => 'Dead Name',
            'solar_dt' => 'Solar Dt',
            'lunar_dt' => 'Lunar Dt',
            'time' => 'Time',
            'intro' => 'Intro',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
