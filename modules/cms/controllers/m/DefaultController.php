<?php

namespace app\modules\cms\controllers\m;


class DefaultController extends \app\modules\m\controllers\DefaultController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
