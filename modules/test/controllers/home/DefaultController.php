<?php

namespace app\modules\test\controllers\home;


class DefaultController extends \app\core\web\HomeController
{
    public function actionIndex()
    {
    	// p($this->view->theme);die;
        return $this->render('index');
    }
}
