<?php

namespace app\modules\sms\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%email_send}}".
 *
 * @property integer $id
 * @property string $email
 * @property string $msg
 * @property string $time
 * @property integer $status
 * @property integer $created_at
 */
class EmailSend extends \app\core\db\ActiveRecord
{

    const STATUS_NORMAL = 1;//待发送

    const STATUS_OK = 0;//发送成功

    const STATUS_FALL = 2;//发送失败

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%email_send}}';
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
            [['email'], 'required'],
            [['email'], 'string', 'max' => 20],
            [['subject', 'from_user', 'from_email'], 'string', 'max' => 200],
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
            'email' => '邮箱',
            'msg' => '消息内容',
            'time' => '发送时间',
            'status' => '状态',
            'created_at' => '添加时间',
            'subject' => '主题'
        ];
    }

    /**
     * @name 添加要发送的短信
     */
    public static function create($email, $subject, $msg, $time, $from_user="", $from_email="")
    {
        $model = new self;
        $model->email = $email;
        $model->msg = $msg;
        $model->time = $time;
        $model->subject = $subject;
        $model->from_email = $from_email;
        $model->from_user = $from_user;

        return $model->save();
    }
}
