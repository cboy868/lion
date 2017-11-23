<?php

namespace app\modules\mess\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%mess_cashbook}}".
 *
 * @property integer $id
 * @property integer $mess_id
 * @property string $note
 * @property string $unit_price
 * @property string $count_price
 * @property integer $type
 * @property integer $op_id
 * @property integer $created_at
 * @property integer $status
 */
class MessCashbook extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mess_cashbook}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mess_id', 'note', 'unit_price', 'count_price', 'type', 'op_id'], 'required'],
            [['mess_id', 'type', 'op_id', 'created_at', 'status'], 'integer'],
            [['unit_price', 'count_price'], 'number'],
            [['note'], 'string', 'max' => 200],
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
            'mess_id' => '食堂',
            'note' => '备注',
            'unit_price' => '单价',
            'count_price' => '总价',
            'type' => '类型',
            'op_id' => '操作人',
            'created_at' => '添加时间',
            'status' => '状态',
        ];
    }
}
