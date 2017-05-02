<?php

namespace app\modules\news\controllers\m;


class DefaultController extends \app\modules\m\controllers\DefaultController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView()
    {
    	return $this->render('view');
    }
}
