<?php

namespace app\modules\shop\controllers\admin;

class DefaultController extends \app\core\web\BackController
{
    /**
     * @return string
     * @name 商品首页
     */
    public function actionIndex()
    {
        return $this->render('index');
    }






}
