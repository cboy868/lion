<?php

namespace app\modules\analysis\controllers\home;


class DefaultController extends \app\core\web\HomeController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
