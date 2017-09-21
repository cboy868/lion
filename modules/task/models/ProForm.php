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
class ProForm extends Model
{

    public $name;

    public $intro;

    public $trigger;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['intro'], 'string'],
            [['trigger'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 200],
//            [['user', 'default', 'msg_type', 'trigger', 'msg_time', 'pid'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => '任务名',
            'intro' => '介绍',
            'pid' => '项目',
            'trigger' => '触发方式'
        ];
    }

    public function update()
    {   

        if ($this->validate()) {
            $info_id = Yii::$app->request->get('id');
            $info = Info::findOne($info_id);

            $info->name = $this->name;
            $info->intro = $this->intro;
            $info->trigger = $this->trigger;
            $info->save();

            return $info;
        }

    }



    public function create()
    {   

        if ($this->validate()) {
            $info = new Info();
            $info->name = $this->name;
            $info->intro = $this->intro;
            $info->trigger = $this->trigger;

            $info->save();

            return $info;
        }

        return $this;

    }
}
