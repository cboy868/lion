<?php

namespace app\modules\wechat\controllers\m;


class DefaultController extends \app\core\web\MController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
