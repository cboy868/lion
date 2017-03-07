<?php

namespace app\modules\task\models;

use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "{{%task_info}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property string $msg
 * @property integer $status
 * @property integer $created_at
 */
class Info extends \app\core\db\ActiveRecord
{
    const MSG_SMS = 1;
    const MSG_EMAIL = 2;

    const TRIGGER_PAY = 1;
    const TRIGGER_CONFIRM = 2;


    public static function trig($trigger = null)
    {
        $t = [
            self::TRIGGER_PAY => '支付时',
            self::TRIGGER_CONFIRM => '确认时'
        ];

        if ($trigger === null) {
            return $t;
        }

        return $t[$trigger];
    }
    public static function msgType($type = null)
    {
        $t = [
            self::MSG_SMS => '手机短信',
            self::MSG_EMAIL => '邮件'
        ];


        if ($type === null) {
            return $t;
        }

        return $t[$type];
    }

    public function getMsgType()
    {
        $types = explode(',', $this->msg_type);

        $result = '';
        foreach ($types as $k => $v) {
            $result .= self::msgType($v) . ',';
        }

        return trim($result, ',');
    }

    public function getTimes()
    {
        $arr = explode(',', $this->msg_time);

        $result = '';
        foreach ($arr as $k => $v) {
            if ($v == 0) {
                $result .= '当天,';
            }
            if ($v < 0) {
                $result .= '提前' . abs($v) . '天,';
            }
            if ($v == 1) {
                $result .= '马上,';
            }
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_info}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['intro', 'msg'], 'string'],
            [['status', 'created_at', 'trigger'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 200],
            [['msg_type', 'msg_time'], 'safe'],
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
            'name' => '任务名',
            'intro' => '介绍',
            'msg' => '消息内容',
            'statusText' => '状态',
            'created_at' => '添加时间',
            'msg_type' => '提醒方式',
            'msg_time' => '消息提醒时间',
            'trigger' => '触发方式',//支付，确认，
        ];
    }

    public function getDefault()
    {
        return $this->hasOne(User::className(),['info_id'=>'id'])->where(['default'=>1]);

    }

    public function getUsers()
    {
        return $this->hasMany(User::className(),['info_id'=>'id']);
    }

    public function getGoodsRels()
    {
        return $this->hasMany(Goods::className(),['info_id'=>'id']);
    }
}
