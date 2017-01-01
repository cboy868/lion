<?php

namespace app\modules\shop\controllers\admin;

use Yii;
use app\core\web\BackController;

use app\modules\shop\models\Order;
use app\modules\shop\models\OrderRel;
use app\modules\shop\models\OrderPay;
use app\modules\shop\models\Goods;
use app\modules\shop\models\Sku;
use app\modules\shop\models\OrderRefund;
use app\modules\shop\models\Pay;
/**
 * GoodsController implements the CRUD actions for Goods model.
 */
class TestController extends BackController
{
    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionCreate()
    {
        $order = Order::create(1, ['note'=> '备注']);
        $sku = Sku::findOne(4);
        $goods = Goods::findOne($sku->goods_id);

        OrderRel::create($order, $goods, $sku, [
            'num'=>2, 
            'note'=>'备注内容', 
            'use_time'=>date('Y-m-d H:i:s', strtotime('+1 day'))
            ]);

        Order::updatePrice($order->id);

        echo '创建订单完成';
    }


    public function actionPayCreate()
    {

        $order = Order::findOne(1);
        Pay::create($order);
    }


    public function actionPay()
    {
        $pay = Pay::find()->where(['order_no'=>'2016102600000103'])->one();

        $order = Order::findOne($pay->order_id);
        $pay->on(Pay::EVENT_AFTER_PAY, [$order, 'afterPay'], null, false);
        
        $pay->pay(1, 21);
    }
}
