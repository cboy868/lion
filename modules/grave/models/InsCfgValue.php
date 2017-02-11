<?php

namespace app\modules\grave\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%grave_ins_cfg_value}}".
 *
 * @property integer $id
 * @property integer $case_id
 * @property string $mark
 * @property integer $sort
 * @property integer $size
 * @property integer $x
 * @property integer $y
 * @property string $color
 * @property integer $direction
 * @property string $text
 * @property string $add_time
 */
class InsCfgValue extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_ins_cfg_value}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['case_id', 'mark', 'size', 'x', 'y'], 'required'],
            [['case_id', 'sort', 'size', 'x', 'y', 'direction', 'is_big', 'add_time'], 'integer'],
            [['mark'], 'string', 'max' => 20],
            [['color'], 'string', 'max' => 10],
            [['text'], 'string', 'max' => 100],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['add_time']
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
            'case_id' => 'Case ID',
            'mark' => 'Mark',
            'sort' => 'Sort',
            'size' => 'Size',
            'x' => 'X',
            'y' => 'Y',
            'color' => 'Color',
            'direction' => 'Direction',
            'text' => 'Text',
            'add_time' => 'Add Time',
            'is_big' => '字体大小'
        ];
    }
}
