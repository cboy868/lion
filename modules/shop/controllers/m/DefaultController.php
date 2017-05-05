<?php

namespace app\modules\shop\controllers\m;


class DefaultController extends \app\modules\m\controllers\DefaultController
{
	/**
	 * @name 商品首页
	 */
	public function actionIndex()
	{
		return $this->render('index');
	}

	/**
	 * @name 商品详情
	 */
	public function actionView()
	{
		$this->layout = "@app/modules/m/views/layouts/nofooter.php";
		return $this->render('view', [
			'get' => \Yii::$app->request->get()
		]);
	}

	/**
	 * @name 购物车
	 */
	public function actionCart()
	{
		$this->layout = "@app/modules/m/views/layouts/nofooter.php";
		return $this->render('cart');
	}
}
