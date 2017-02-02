<?php

namespace app\modules\order\controllers\home;



use app\modules\shop\models\Gooods;
use app\modules\shop\models\Sku;
use app\modules\order\models\Order;
use app\modules\order\models\Pay;

class DefaultController extends \app\core\web\HomeController
{
    public function actionIndex()
    {

    	// $sku = Sku::findOne(37);
    	// $a = $sku->order(['order_note'=> '最新订单', 'note'=>'note记录', 'use_time'=>'2016-02-02 22:12:00', 'num'=>10]);

    	$order = Order::findOne(5);
    	Pay::pay($order, Pay::METHOS_CASH, 360);

        return $this->render('index');
    }
}
