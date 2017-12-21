<?php

namespace app\modules\order\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%order_discount}}".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $rel_id
 * @property string $discount
 * @property string $reduce
 * @property string $ori_price
 * @property string $price
 * @property integer $op_id
 * @property integer $leader
 * @property string $intro
 * @property integer $updated_at
 * @property integer $created_at
 * @property integer $status
 */
class Discount extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_discount}}';
    }


    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'rel_id', 'discount', 'reduce', 'ori_price', 'price', 'op_id',
                'leader'], 'required'],
            [['order_id', 'rel_id', 'op_id', 'leader', 'updated_at', 'created_at', 'status'], 'integer'],
            [['discount', 'reduce', 'ori_price', 'price'], 'number'],
            [['intro'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => '订单id',
            'rel_id' => '子订单',
            'discount' => '折扣',
            'reduce' => '除零',
            'ori_price' => '原价',
            'price' => '折后价',
            'op_id' => '申请人',
            'leader' => '审批人',
            'intro' => '备注',
            'updated_at' => '审批时间',
            'created_at' => '提交时间',
            'status' => '状态',
        ];
    }
}
