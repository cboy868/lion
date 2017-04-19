<?php
namespace app\modules\home\controllers;

use Yii;

class DefaultController extends HomeController
{
   public function actionIndex()
   {
        return $this->render('index');
   }
}
