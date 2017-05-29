<?php

namespace app\modules\grave\controllers\m;


class DefaultController extends \app\core\web\MController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionIns()
    {
        return $this->render('confirm');
    }

    public function actionPortrait()
    {
        return $this->render('confirm');
    }
}
