<?php

namespace app\modules\sms\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%sms_send}}".
 *
 * @property integer $id
 * @property integer $created_at
 */
class Send extends \app\core\db\ActiveRecord
{

    const STATUS_NORMAL = 1;//待发送

    const STATUS_OK = 0;//发送成功

    const STATUS_FALL = 2;//发送失败

    public $type;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sms_send}}';
    }

    public static function status($status = null)
    {
        $s = [
            self::STATUS_DEL => '删除',
            self::STATUS_NORMAL => '待发送',
            self::STATUS_OK => '发送成功',
            self::STATUS_FALL => '发送失败'
        ];

        if ($status === null) {
            return $s;
        }

        return $s[$status];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['msg'], 'string'],
            [['time'], 'safe'],
            [['status', 'created_at'], 'integer'],
            [['mobile', 'msg'], 'required'],
            [['mobile'], 'string', 'max' => 20],
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
            'mobile' => '手机号',
            'msg' => '消息内容',
            'time' => '发送时间',
            'statusText' => '状态',
            'created_at' => '添加时间',
            'type' => '发送目标'
        ];
    }
}
