<?php

namespace app\modules\cms\controllers\m;


class DefaultController extends \app\core\web\MController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView($mid, $id)
    {
        return $this->render('view', [
            'mid' => $mid,
            'id' => $id
        ]);
    }
}
