<?php

namespace app\modules\analysis\controllers\program;


class DefaultController extends \app\core\web\ProgramController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
