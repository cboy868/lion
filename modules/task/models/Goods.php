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
            [['info_id', 'res_id', 'msg_type', 'trigger'], 'integer'],
            [['msg', 'msg_time'], 'string'],
            [['res_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'info_id' => 'Info ID',
            'res_name' => 'Res Name',
            'res_id' => 'Res ID',
            'msg_type' => 'Msg Type',
            'msg' => 'Msg',
            'msg_time' => 'Msg Time',
            'trigger' => 'Trigger',
        ];
    }
}
