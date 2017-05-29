<?php

namespace app\modules\news\controllers\m;


class DefaultController extends \app\core\web\MController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView()
    {

    	return $this->render('view', [
			'get' => \Yii::$app->request->get()
		]);
    }
}
