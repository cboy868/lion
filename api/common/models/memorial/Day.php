<?php

namespace api\common\models\memorial;

use Yii;

/**
 * This is the model class for table "{{%memorial_day}}".
 *
 * @property integer $id
 * @property integer $memorial_id
 * @property string $date
 * @property integer $date_type
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $status
 */
class Day extends \api\common\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%memorial_day}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['memorial_id', 'date_type', 'created_by', 'created_at', 'status'], 'integer'],
            [['memorial_id','date'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'memorial_id' => '纪念馆',
            'date' => '日期',
            'date_type' => '日期类型',
            'created_by' => '添加人',
            'created_at' => '添加时间',
            'status' => 'Status',
        ];
    }
}
