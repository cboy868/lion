<?php

namespace app\modules\order\controllers\m;

use yii;

class DefaultController extends \app\core\web\MController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView()
    {
    	return $this->render('view', [
    			'get' => Yii::$app->request->get()
    		]);
    }
}
