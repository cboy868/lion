<?php

namespace app\modules\task\models;

use Yii;

/**
 * This is the model class for table "{{%task_goods}}".
 *
 * @property integer $id
 * @property integer $info_id
 * @property string $res_name
 * @property integer $res_id
 * @property integer $msg_type
 * @property string $msg
 * @property string $msg_time
 * @property integer $trigger
 */
class Goods extends \app\core\db\ActiveRecord
{

    const RES_CATEGORY = 'category';
    const RES_GOODS = 'goods';

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

    public static function res($res = null)
    {
        $r = [
            self::RES_CATEGORY => '商品分类',
            self::RES_GOODS => '商品'
        ];


        if ($res === null) {
            return $r;
        }

        return $r[$res];
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


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_goods}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['info_id', 'trigger'], 'integer'],
            [['msg', 'msg_time'], 'string'],
            [['res_name'], 'string', 'max' => 255],
            [['res_id', 'msg_type'], 'safe'],
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->msg_type = implode(',', $this->msg_type);
        $this->res_id = implode(',', $this->res_id[$this->res_name]);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'info_id' => '任务类型',
            'res_name' => '关联类型',
            'res_id' => '类型id',
            'msg_type' => '提醒方式',
            'msg' => '消息内容',
            'msg_time' => '消息提醒时间',
            'trigger' => '触发方式',//支付，确认，
        ];
    }

    public function getInfo()
    {
        return $this->hasOne(Info::className(),['id'=>'info_id']);
    }
}
