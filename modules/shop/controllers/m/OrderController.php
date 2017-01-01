<?php

namespace app\modules\shop\controllers\m;


class OrderController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionList()
    {
        return $this->render('list');
    }


    public function actionView()
    {
    	return $this->render('view');
    }


    public function actionCart()
    {
    	return $this->render('cart');
    }

    public function actionBuy()
    {
    	return $this->render('buy');
    }


    public function actionPay()
    {
    	return $this->render('pay');
    }
}
