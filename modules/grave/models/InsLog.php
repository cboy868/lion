<?php

namespace app\modules\grave\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%grave_ins_log}}".
 *
 * @property integer $id
 * @property integer $ins_id
 * @property integer $op_id
 * @property integer $tomb_id
 * @property string $action
 * @property string $img
 * @property string $content
 * @property integer $status
 * @property integer $updated_at
 * @property integer $created_at
 */
class InsLog extends \app\core\db\ActiveRecord
{

    const ACTION_CONFIRM = 'confirm';
    const ACTION_TASK = 'task';
    const ACTION_PAY = 'pay';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_ins_log}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ins_id', 'op_id', 'tomb_id'], 'required'],
            [['ins_id', 'op_id', 'tomb_id', 'status', 'updated_at', 'created_at'], 'integer'],
            [['content'], 'string'],
            [['action'], 'string', 'max' => 100],
            [['img'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ins_id' => 'Ins ID',
            'op_id' => 'Op ID',
            'tomb_id' => 'Tomb ID',
            'action' => 'Action',
            'img' => 'Img',
            'content' => 'Content',
            'status' => 'Status',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    public static function log($ins,$user_id, $action,$front=null, $back=null)
    {

        $model = new self;

        $model->ins_id = $ins->id;
        $model->op_id = $user_id;
        $model->tomb_id = $ins->tomb_id;
        $model->action = $action;
        $model->img = json_encode(['front'=>$front, 'back'=>$back]);
        $model->content = $ins->content;

        return $model->save();

    }
}
