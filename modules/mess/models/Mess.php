<?php

namespace app\modules\mess\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%mess}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $note
 * @property integer $status
 * @property integer $created_at
 */
class Mess extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mess}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status', 'created_at'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['note'], 'string'],
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
            'name' => '食堂名',
            'note' => '备注',
            'status' => '状态',
            'created_at' => '添加时间',
        ];
    }

    public static function sel()
    {
        $all = self::find()->where(['<>', 'status', self::STATUS_DEL])->all();
        return ArrayHelper::map($all, 'id', 'name');
    }


}
