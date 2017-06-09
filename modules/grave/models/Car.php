<?php

namespace app\modules\grave\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%grave_car}}".
 *
 * @property integer $id
 * @property string $code
 * @property integer $type
 * @property integer $keeper
 * @property string $note
 * @property integer $status
 * @property integer $created_at
 */
class Car extends \app\core\db\ActiveRecord
{
    const TYPE_LING = 1;
    const TYPE_FENG = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_car}}';
    }

    public static function types($type=null)
    {
        $t = [
            self::TYPE_LING => '迎灵车',
            self::TYPE_FENG => '风行车'
        ];

        return $type===null ? $t : $t[$type];
    }

    public function getCarType()
    {
        return self::types($this->type);
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
            [['type', 'keeper', 'status', 'created_at'], 'integer'],
            [['note'], 'string'],
            [['code', 'type'], 'required'],
            [['code'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => '车牌号',
            'type' => '车辆类型',
            'keeper' => '保存人',//目前不用
            'note' => '车辆备注',
            'status' => '状态',
            'created_at' => '添加时间',
            'carType' => '车辆类型'
        ];
    }
}
