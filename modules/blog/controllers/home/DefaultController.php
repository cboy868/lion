<?php

namespace app\modules\blog\controllers\home;


class DefaultController extends \app\modules\home\controllers\DefaultController
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
