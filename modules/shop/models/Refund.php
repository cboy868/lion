<?php

namespace app\modules\shop\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%order_pay}}".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $order_no
 * @property integer $trade_no
 * @property string $total_fee
 * @property string $total_pay
 * @property integer $pay_method
 * @property integer $pay_result
 * @property integer $mid
 * @property integer $wechat_uid
 * @property string $paid_at
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $checkout_at
 * @property string $note
 * @property integer $status
 */
class Refund extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_order_refund}}';
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
            [['order_id', 'wechat_uid', 'progress', 'created_at', 'updated_at', 'status'], 'integer'],
            [['fee'], 'number'],
            [['intro', 'note'], 'string'],
            [['checkout_at'], 'safe'],
            [['created_at', 'updated_at'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'wechat_uid' => 'Wu ID',
            'fee' => 'Fee',
            'progress' => 'Progress',
            'intro' => 'Intro',
            'note' => 'Note',
            'checkout_at' => 'Checkout At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
