<?php

namespace app\modules\order\models;

use Yii;
use app\modules\shop\models\Order;
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
 * @property integer $wechat_uid
 * @property string $paid_at
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $checkout_at
 * @property string $note
 * @property integer $status
 */
class Payment extends Pay
{
}
