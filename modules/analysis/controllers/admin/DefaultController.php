<?php

namespace app\modules\analysis\controllers\admin;


class DefaultController extends \app\core\web\BackController
{
    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionTestJson()
    {
    	$data['cate'] = ["衬衫","羊毛衫","雪纺衫","裤子","高跟鞋","袜子"];
    	$data['data'] = [5, 20, 36, 10, 10, 20];

    	return $this->json($data);
    }
}
