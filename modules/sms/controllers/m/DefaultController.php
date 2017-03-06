<?php

namespace app\modules\sms\controllers\m;


class DefaultController extends \app\core\web\MController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
