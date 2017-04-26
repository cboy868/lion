<?php
namespace app\modules\home\controllers;

use Yii;

class DefaultController extends HomeController
{

	public $layout = "home.php";
	public function actionIndex()
	{
	    return $this->render('index');
	}
}
