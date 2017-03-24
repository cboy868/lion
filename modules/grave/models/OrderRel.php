<?php

namespace app\modules\grave\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\user\models\User;

/**
 * This is the model class for table "{{%order_rel}}".
 *
 * @property integer $id
 * @property integer $wechat_uid
 * @property string $title
 * @property integer $type
 * @property integer $category_id
 * @property integer $goods_id
 * @property integer $order_id
 * @property string $price
 * @property string $price_unit
 * @property integer $num
 * @property string $use_time
 * @property string $note
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class OrderRel extends \app\modules\order\models\OrderRel
{

    const TYPE_TOMB = 9; //墓位订单
    /**
     * @name 墓位订单
     */
    public static function createTombOrder($order, $tomb, $data)
    {

        $model = self::hasRel($order->id, $tomb->id, $tomb->id, $order->user_id, self::TYPE_TOMB);

        if (!$model) {
            $model = new OrderRel;
        }

        $data = [
            'type'          => self::TYPE_TOMB,
            'user_id'       => $order->user_id,
            'op_id'         => Yii::$app->user->id,
            'order_id'      => $order->id,
            'goods_id'      => $tomb->id,
            'sku_id'        => $tomb->id,
            'category_id'   => $tomb->grave->id,//墓区
            'title'         => $tomb->tomb_no,
            'price_unit'    => $tomb->price,
            'price'         => $tomb->price,
            'sku_name'      => $tomb->tomb_no,
            'num'           => 1,
            'note'          => isset($data['note']) ? $data['note'] : '',
            'use_time'      => isset($data['use_time']) ? $data['use_time'] : date('Y-m-d H:i:s', strtotime('+3 day')),
        ];

        $model->load($data, '');
        $model->save();
        return $model;
    }

    // public static function getInsOrderRel($tomb_id)
    // {
        
    // }

}
