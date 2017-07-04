<?php

namespace app\modules\ashes\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "ashes_area".
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $level
 * @property string $code
 * @property integer $is_leaf
 * @property string $title
 * @property integer $row
 * @property integer $col
 * @property integer $status
 * @property string $intro
 * @property integer $created_at
 */
class Area extends \app\core\models\Category
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ashes_area}}';
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
    public function rules()
    {
        return [
            [['pid', 'level', 'is_leaf', 'row', 'col', 'status', 'created_at'], 'integer'],
            [['intro'], 'string'],
            [['title'], 'required'],
            [['code'], 'string', 'max' => 64],
            [['title'], 'string', 'max' => 32],
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
            'level' => 'Level',
            'code' => 'Code',
            'is_leaf' => '是否叶子节点',
            'title' => '架区名',
            'row' => '排数',
            'col' => '列数',
            'status' => '状态',
            'intro' => '介绍',
            'created_at' => '添加时间',
        ];
    }
}
