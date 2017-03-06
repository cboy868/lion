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
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['intro', 'msg'], 'string'],
            [['name', 'user'], 'required'],
            [['name'], 'string', 'max' => 200],
            [['user', 'default'], 'safe'],
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
            'created_at' => '添加时间',
            'user' => '任务接收人',
            'default' => '直接处理人'
        ];
    }


    public function create()
    {   
        if ($this->validate()) {
            $info = new Info();
            $info->name = $this->name;
            $info->msg = $this->msg;
            $info->intro = $this->intro;

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
