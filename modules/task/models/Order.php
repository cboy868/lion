<?php

namespace app\modules\task\models;

use Yii;

/**
 * This is the model class for table "{{%task_order}}".
 *
 * @property integer $id
 * @property integer $task_id
 * @property integer $order_id
 * @property integer $order_rel_id
 */
class Order extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id', 'order_id', 'order_rel_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'order_id' => 'Order ID',
            'order_rel_id' => 'Order Rel ID',
        ];
    }
}
