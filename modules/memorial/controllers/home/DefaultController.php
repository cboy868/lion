<?php

namespace app\modules\memorial\controllers\home;

use app\modules\memorial\models\Memorial;

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

    public function actionView($id)
    {
        $this->layout = "@app/modules/home/views/layouts/memorial.php";

        $model = Memorial::findOne($id);

        if (!$model) {
            return $this->error('不存在此纪念馆');
        }

        $data = $model->toArray();

    	return $this->render('view', ['data'=>$data]);
    }
}
