<?php

namespace app\modules\shop\controllers\m;


class DefaultController extends \app\modules\m\controllers\DefaultController
{
	public function actionIndex()
	{
		return $this->render('index');
	}
}
