<?php

namespace app\modules\agency\controllers\m;


class DefaultController extends \app\core\web\MController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
