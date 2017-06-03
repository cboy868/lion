<?php

namespace app\modules\grave\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\shop\models\Cart;
use app\modules\user\models\User;
use app\modules\grave\models\OrderRel;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $price
 * @property string $origin_price
 * @property integer $type
 * @property integer $progress
 * @property string $note
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class Order extends \app\modules\order\models\Order
{

    const TYPE_TOMB = 9;

    public static function createTombOrder($user_id, $tomb, $extra=[])
    {
        try {
            $extra['type'] = self::TYPE_TOMB;
            $extra['tid']  = $tomb->id;

            $order = self::getValidOrder($user_id, $extra);

            OrderRel::createTombOrder($order, $tomb, $extra);
           $a = OrderRel::createCardOrder($order, $tomb);
            $order->updatePrice();
        } catch (\Exception $e) {
            echo $e->getMessage();
            Yii::error($e->getMessage(), __METHOD__);
            return false;
        }
        return $order;
    }
}
