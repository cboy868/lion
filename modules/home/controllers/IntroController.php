<?php

namespace app\modules\home\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class IntroController extends HomeController
{
   
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
    	return $this->render('index');
    }

}
