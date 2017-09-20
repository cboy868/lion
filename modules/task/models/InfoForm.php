<?php

namespace app\modules\task\models;

use Yii;
use yii\base\Model;
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
class InfoForm extends Model
{

    public $name;

    public $msg;

    public $intro;

    public $user;

    public $default;

    public $trigger;

    public $msg_type;

    public $msg_time;

    public $task_time;

    public $pid;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['intro', 'msg'], 'string'],
            [['trigger'], 'integer'],
            [['name', 'user', 'pid'], 'required'],
            [['name'], 'string', 'max' => 200],
            [['user', 'default', 'msg_type', 'trigger', 'msg_time', 'task_time', 'pid'], 'safe'],
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
            'msg_time' => '提醒时间',
            'task_time'=> '任务时间',
            'created_at' => '添加时间',
            'user' => '任务接收人',
            'default' => '直接处理人',
            'pid' => '项目',
            'msg_type' => '消息提醒类型'
        ];
    }



// $msg_type = implode(',', $model->msg_type);

//             foreach ($model->res_id[$model->res_name] as $k => $v) {
//                 $m = new Goods();
//                 $m->info_id = $model->info_id;
//                 $m->msg_type = $msg_type;
//                 $m->res_name = $model->res_name;
//                 $m->msg = $model->msg;
//                 $m->msg_time = $model->msg_time;
//                 $m->trigger = $model->trigger;
//                 $m->res_id = $v;

//                 $m->save();

//                 unset($m);
//             }


    public function update()
    {   

        if ($this->validate()) {
            $info_id = Yii::$app->request->get('id');
            $info = Info::findOne($info_id);


            $info->name = $this->name;
            $info->msg = $this->msg;
            $info->intro = $this->intro;
            $info->msg_type = implode(',', $this->msg_type);
            $info->msg_time = $this->msg_time;
            $info->task_time = $this->task_time;
            $info->trigger = $this->trigger;

            $connection = Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {

                $info->save();


                foreach ($this->user as $u) {
                    $data[$u] = [
                        'info_id' => $info->id,
                        'user_id' => $u,
                        'default' => 0
                    ];
                }
                if ($this->default) {
                    $data[$this->default]['default'] = 1;
                }


                User::deleteAll('info_id = :info_id', [':info_id' => $info_id]);
                
                $connection->createCommand()->batchInsert(
                    User::tableName(), 
                    [
                    'info_id',
                    'user_id',
                    'default',
                    ], 
                    $data
                )->execute();

                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                return false;
            }

            return $info;
        }

    }



    public function create()
    {   

        if ($this->validate()) {
            $info = new Info();
            $info->name = $this->name;
            $info->msg = $this->msg;
            $info->intro = $this->intro;
            $info->pid = $this->pid;
            $info->msg_type = implode(',', $this->msg_type);
            $info->msg_time = $this->msg_time;
            $info->task_time = $this->task_time;
            $info->trigger = $this->trigger;


            $connection = Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {

                $info->save();

                foreach ($this->user as $u) {
                    $data[$u] = [
                        'info_id' => $info->id,
                        'user_id' => $u,
                        'default' => 0
                    ];
                }
                if ($this->default) {
                    $data[$this->default]['default'] = 1;
                }

                
                $connection->createCommand()->batchInsert(
                    User::tableName(), 
                    [
                    'info_id',
                    'user_id',
                    'default',
                    ], 
                    $data
                )->execute();

                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                return false;
            }

            return $info;
        }


    }
}
