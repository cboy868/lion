<?php

namespace app\modules\task\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\user\models\User;

/**
 * This is the model class for table "{{%task}}".
 *
 * @property integer $id
 * @property integer $cate_id
 * @property string $res_name
 * @property integer $res_id
 * @property integer $user_id
 * @property integer $order_rel_id
 * @property integer $op_id
 * @property string $title
 * @property string $content
 * @property string $pre_finish
 * @property string $finish
 * @property integer $status
 * @property integer $created_at
 */
class Task extends \app\core\db\ActiveRecord
{

    const  STATUS_FINISH = 2;//完成
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cate_id', 'res_id', 'user_id', 'order_rel_id', 'op_id', 'status', 'created_at'], 'integer'],
            [['content'], 'string'],
            [['pre_finish', 'finish'], 'safe'],
            [['cate_id', 'title'], 'required'],
            [['res_name', 'title'], 'string', 'max' => 200],
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

    public static function status($status = null)
    {
        $s = [
            self::STATUS_DEL => '删除',
            self::STATUS_NORMAL => '正常',
            self::STATUS_FINISH => '完成'
        ];

        if ($status === null) {
            return $s;
        }

        return $s[$status];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cate_id' => '任务分类',
            'res_name' => '任务类型',
            'res_id' => '关联id',
            'user_id' => '发起人',
            'order_rel_id' => '关联定单',
            'op_id' => '操作人',
            'title' => '任务标题',
            'content' => '任务内容',
            'pre_finish' => '预定完成时间',
            'finish' => '实际完成时间',
            'status' => '状态',
            'statusText' => '状态',
            'created_at' => '添加时间',
            'op.username'=>'操作人'
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->op_id = $this->info->default->user_id;
        $this->user_id = $this->user_id ? $this->user_id : Yii::$app->user->id;
        $this->res_name = 'common';
        $this->res_id = 0;
        return true;
    }

    public function finish()
    {
        $this->status = self::STATUS_FINISH;
        $this->finish = date('Y-m-d H:i:s');
        return $this->save();
    }

    public function getUser()
    {
        return $this->hasOne(User::className(),['id'=>'user_id']);
    }
    public function getOp()
    {
        return $this->hasOne(User::className(),['id'=>'op_id']);
    }
    public function getInfo()
    {
        return $this->hasOne(Info::className(),['id'=>'cate_id']);
    }
}
