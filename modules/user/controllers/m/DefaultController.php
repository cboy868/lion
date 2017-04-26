<?php

namespace app\modules\user\controllers\m;


class DefaultController extends \app\modules\m\controllers\DefaultController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
