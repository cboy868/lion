<?php

namespace app\modules\grave\controllers\m;


class DefaultController extends \app\core\web\MController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionConfirm()
    {
        $this->layout = "@app/modules/m/views/layouts/nofooter.php";
        return $this->render('confirm');
    }
}
