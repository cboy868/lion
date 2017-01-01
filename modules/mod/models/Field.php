<?php

namespace app\modules\mod\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%module_field}}".
 *
 * @property integer $id
 * @property string $table
 * @property string $name
 * @property string $title
 * @property string $pop_note
 * @property string $html
 * @property string $option
 * @property string $default
 * @property integer $is_show
 * @property integer $order
 * @property integer $created_at
 */
class Field extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%module_field}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['table', 'name'], 'required'],
            [['option', 'default'], 'string'],
            [['is_show', 'order', 'created_at'], 'integer'],
            [['table'], 'string', 'max' => 45],
            [['name', 'title', 'pop_note'], 'string', 'max' => 255],
            [['html'], 'string', 'max' => 100],
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
            'table' => '表',
            'name' => '字段',
            'title' => '字段名',
            'pop_note' => '提示信息',
            'html' => '输入类型',
            'option' => '选项',
            'default' => '默认值',
            'is_show' => '是否显示',
            'order' => '排序',
            'created_at' => '添加时间',
        ];
    }
}
