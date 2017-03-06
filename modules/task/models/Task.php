<?php

namespace app\modules\task\models;

use Yii;

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
            [['created_at'], 'required'],
            [['res_name', 'title'], 'string', 'max' => 200],
        ];
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
            'created_at' => '添加时间',
        ];
    }
}
