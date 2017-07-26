<?php

namespace app\modules\task\models;

use app\core\helpers\ArrayHelper;
use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\grave\models\Tomb;


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
class Info extends \app\core\models\Category
{
    const MSG_SMS = 1;
    const MSG_EMAIL = 2;

    const TRIGGER_PAY = 1;
    const TRIGGER_CONFIRM = 2;
    const Trigger_other = 3;


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

    public static function getInfos()
    {
        $infos = self::find()
            ->where(['status' => self::STATUS_ACTIVE])
            ->andWhere(['pid'=>0])
            ->asArray()
            ->all();

        return ArrayHelper::map($infos, 'id', 'name');
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
            if ($v == 'atonce') {
                $result .= '马上,';
            }
            if ($v > 0) {
                $result .= '延后' . abs($v) . '天,任务完成时间相应延后';
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
            [['status', 'created_at', 'trigger','pid', 'level', 'is_leaf',], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 200],
            [['msg_type', 'msg_time', 'code'], 'safe'],
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
            'pid' => '项目'
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


    /**
     * @name 项目负责创建任务
     */
    public function createTask($order_rel, $res_name, $res_id)
    {
        $items = $this->getDirectSon();

        if (!$items) return ;

        $common_data = [
            'res_name' => $res_name,
            'res_id' => $res_id,
            'user_id' => 0,
            'pre_finish' => $order_rel->use_time,
            'order_rel_id' => $order_rel->id
        ];

        foreach ($items as $item) {

            $content = $item->msg;
            $content = self::replace($order_rel, $content, $res_name, $res_id);

            $data = array_merge($common_data, [
                'cate_id' =>$item->id,
                'title'  => $item->name,
                'op_id'  => $item->default->user_id,
                'content' => $content,
            ]);

            $msg_time = str_replace('，', ',', $item->msg_time);
            $msgs = explode(',', $msg_time);

            foreach ($msgs as $v) {
                $model = new Task();

                $model->load($data, '');

                if ($v == 'atonce') {//马上
                    $model->msg_time = date('Y-m-d H:i:s');
                } else if ($v == 0) { //当天
                    $model->msg_time = $data['pre_finish'];
                } else {
                    $model->msg_time = date('Y-m-d H:i:s', strtotime($data['pre_finish'] .' '. $v .' days'));

                    if ($v > 0) {
                        $model->pre_finish = $model->msg_time;
                    }
                }

                $model->save();
                unset($model);
            }
        }
    }

    public static function replace($rel, $content, $res_name='common', $res_id=0)
    {
        $replace = [
            'search' => [
                '{pre_finish}','{rel_note}', '{order_id}' , '{goods}'
            ],
            'replace' => [
                $rel->use_time, $rel->note, $rel->order_id, $rel->title
            ]
        ];

        if ($res_name == 'tomb') {
            $tomb = Tomb::findOne($res_id);
            $replace['search'][] = '{tomb_no}';
            $replace['replace'][] = $tomb->tomb_no;
        }

        return str_replace($replace['search'], $replace['replace'], $content);
    }
}
