<?php

namespace app\modules\shop\controllers\home;


class DefaultController extends \app\core\web\HomeController
{
	/**
	 * @name 商品聚合页面
	 */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @name 商品列表页面
     */
    public function actionList()
    {

    }

    /**
     * @name 商品详情页面
     */
    public function actionView()
    {

    }
}
