<?php

namespace app\core\web;

/**
 * Default controller for the `wechat` module
 */
class HomeController extends \app\core\web\Controller
{

	public $layout = "@app/core/views/layouts/home.php";

	// public $layout = "home.php";

	public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            return true;
        }
    }

    public function success($url = [] ,$sec = 3){  
        $url= empty($url)? ['/admin']: $url;
        $url= \yii\helpers\Url::toRoute($url);
        return $this->renderPartial('@app/core/views/single/msg',['gotoUrl'=>$url,'sec'=>$sec]);
    }

    public function error($msg= '',$sec = 3){
//    	\Yii::$app->getSession()->setFlash('error', '错误');
        return $this->renderPartial('@app/core/views/single/msg',['errorMessage'=>$msg,'sec'=>$sec]);
    }
}
