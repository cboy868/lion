<?php

namespace app\modules\approval\controllers\home;


class DefaultController extends \app\core\web\HomeController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
