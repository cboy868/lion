<?php

namespace app\modules\memorial\controllers\home;


class DefaultController extends \app\modules\home\controllers\DefaultController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPanel()
    {
    	return $this->render('panel');
    }

    public function actionRemote()
    {
        return $this->render('remote');
    }

    public function actionView()
    {
    	return $this->render('view');
    }
}
