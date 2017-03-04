<?php

namespace app\modules\task\models;

use Yii;

/**
 * This is the model class for table "{{%task}}".
 *
 * @property integer $id
 * @property integer $cate_id
 * @property integer $grave_id
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
            [['cate_id', 'grave_id', 'res_id', 'user_id', 'order_rel_id', 'op_id', 'status', 'created_at'], 'integer'],
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
            'cate_id' => 'Cate ID',
            'grave_id' => 'Grave ID',
            'res_name' => 'Res Name',
            'res_id' => 'Res ID',
            'user_id' => 'User ID',
            'order_rel_id' => 'Order Rel ID',
            'op_id' => 'Op ID',
            'title' => 'Title',
            'content' => 'Content',
            'pre_finish' => 'Pre Finish',
            'finish' => 'Finish',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}
