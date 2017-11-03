<?php

namespace app\modules\analysis\controllers\mobile;


class DefaultController extends \app\core\web\MobileController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
