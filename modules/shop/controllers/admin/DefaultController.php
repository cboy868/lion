<?php

namespace app\modules\shop\controllers\admin;


class DefaultController extends \app\core\web\BackController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
