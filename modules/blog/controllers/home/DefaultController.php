<?php

namespace app\modules\blog\controllers\home;


class DefaultController extends \app\core\web\HomeController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView()
    {
    	return $this->render('view');
    }
}
