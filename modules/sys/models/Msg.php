<?php

namespace app\modules\sys\models;

use app\modules\cms\models\Message;
use app\modules\grave\models\Grave;
use app\modules\order\models\OrderRel;
use app\modules\user\models\User;
use app\modules\wechat\models\Template;
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


    public static $wechatTpl = [
        'order' => Template::TPL_ORDER,
        'task'  => Template::TPL_TASK,
        'yuyue'  => Template::TPL_YUYUE,
        'yuyue_notice'  => Template::TPL_YUYUE_NOTICE
    ];

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
        Yii::error($this->getErrors(), __METHOD__);
        return false;
    }

    public function send()
    {
        if ($this->msg_type == self::TYPE_WECHAT) {
            if (!isset(self::$wechatTpl[$this->res_name])) {
                return ;
            }


        }
    }

    private function getData()
    {
        switch ($this->res_name) {
            case 'order':
                $rels = OrderRel::find()->where(['status'=>OrderRel::STATUS_NORMAL, 'order_id'=>$this->res_id])->all();
                if (!$rels) {
                    return false;
                }
                $str = '';
                foreach ($rels as $v) {
                    $str .= $v['title'] . ',';
                }
                $data = [
                    'keyword1' => $this->res_id,
                    'keyword2' => $str
                ];
                break;
            case 'task':
                $user = User::findOne($this->user_id);
                $data = [
                    'keyword1' => $user->username,
                    'keyword2' => date('Y-m-d H:i'),
                    'keyword3' => $this->msg
                ];
                break;
            case 'yuyue':
                $model = Message::findOne($this->res_id);
                $title = $model->title;
                if ($model->res_name == 'grave') {
                    $grave = Grave::findOne($model->res_id);
                    $title .= ',墓区:'.$grave->name;
                }
                $data = [
                    'keyword1' => $model->term,
                    'keyword2' => $model->username . '('.$model->mobile.')',
                    'keyword3' => '来园',
                    'keyword4' => $title,
                ];
            case 'yuyue_notice':
                $model = Message::findOne($this->res_id);
                $title = $model->title;
                if ($model->res_name == 'grave') {
                    $grave = Grave::findOne($model->res_id);
                    $title .= ',墓区:'.$grave->name;
                }
                $data = [
                    'keyword1' => $model->username,
                    'keyword2' => $model->mobile,
                    'keyword3' => '预约时间'.$model->term,
                ];

        }
    }


}
