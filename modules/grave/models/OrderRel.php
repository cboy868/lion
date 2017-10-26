<?php

namespace app\modules\grave\models;

use app\modules\shop\models\Goods;
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
            'tid' => $tomb->id,
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
//            'use_time'      => isset($data['use_time']) ? $data['use_time'] : date('Y-m-d H:i:s', strtotime('+3 day')),
            'use_time'      => isset($data['use_time']) ? $data['use_time'] : null,
        ];

        $model->load($data, '');
        $model->save();
        return $model;
    }

    public static function createCardOrder($order, $tomb)
    {
        $params = Yii::$app->getModule('grave')->params['tomb_card'];

//        if ($params['start'] == 'bury') {//墓证费用应该是在这里生成,但不影响时间
//            return ;
//        }

        $goods_id = $params['goods_id'];

        if ($params['first_free']) {
            $gmodel = Goods::createVirtual($goods_id, '墓位维护费(赠送)');
            return self::createGoods($order, $gmodel, ['tid'=>$tomb->id]);
        }

        $gmodel = Goods::createVirtual($goods_id, '墓位维护费', ['price'=>$tomb->price*$params['percent']]);
        return self::createGoods($order, $gmodel, ['tid'=>$tomb->id]);
    }

    public function getTomb()
    {
        return $this->hasOne(Tomb::className(), ['id'=>'tid']);
    }


    // public static function getInsOrderRel($tomb_id)
    // {
        
    // }

}
