<?php

namespace app\modules\sys\models;

use app\modules\user\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%sys_msg}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $msg
 * @property integer $msg_type
 * @property string $msg_time
 * @property string $res_name
 * @property integer $res_id
 * @property integer $tid
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Msg extends \app\core\db\ActiveRecord
{
    const TYPE_SMS = 1;
    const TYPE_EMAIL = 2;
    const TYPE_WECHAT = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_msg}}';
    }

    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
            ]
        ];
    }

    public static function types($type=null)
    {
        $t = [
            self::TYPE_EMAIL => '邮件',
            self::TYPE_SMS => '短信',
            self::TYPE_WECHAT => '微信'
        ];

        return $type === null ? $t : $t[$type];
    }

    public function getTypeLabel()
    {
        return self::types($this->msg_type);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'msg', 'msg_time', 'res_name', 'res_id'], 'required'],
            [['user_id', 'msg_type', 'res_id', 'tid', 'status', 'created_at', 'updated_at'], 'integer'],
            [['msg'], 'string'],
            [['msg_time'], 'safe'],
            [['res_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'msg' => '消息内容',
            'msg_type' => '消息发送方式',
            'msg_time' => '消息时间',
            'res_name' => '类型',
            'res_id' => '类型id',
            'tid' => '墓位id',
            'status' => '状态',
            'created_at' => '添加时间',
            'updated_at' => '更新时间',
            'typeLabel' => '消息发送方式',
            'statusText'=>'状态'
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id'=>'user_id']);
    }

    public static function create($obj, $res_name,$msg, $msg_type=self::TYPE_SMS,$msg_time=null)
    {
        $model = new self();
        $method = 'create' . ucfirst($res_name);

        return $model->$method($obj,$msg, $msg_time, $msg_type);
    }
    public function createOrder($obj, $msg,$msg_time=null,$msg_type=self::TYPE_SMS)
    {
        $this->user_id = $obj->user_id;
        $this->msg = $msg;
        $this->msg_type = $msg_type;
        $this->msg_time = $msg_time ? $msg_time : date('Y-m-d H:i:s');
        $this->res_name = 'order';
        $this->res_id = $obj->id;
        $this->tid = $obj->tid;

        if ($this->save()) {
            return $this;
        }

        p($this->getErrors());die;
        Yii::error($this->getErrors(), __METHOD__);

        return false;

    }





    public static function create2($data)
    {
        $model = new self;

        $model->user_id = $data['user_id'];
        $model->msg = $data['msg'];
        $model->msg_type = $data['msg_type'];
        $model->msg_time = isset($data['msg_time']) ? $data['msg_time'] : date('Y-m-d H:i:s');
        $model->res_name = $data['res_name'];
        $model->res_id = $data['res_id'];
        $model->tid = isset($data['tid']) ? $data['tid'] : 0;

        if ($model->save()) {
            return $model;
        }

        Yii::error($model->getErrors(), __METHOD__);

        return false;


    }
}
