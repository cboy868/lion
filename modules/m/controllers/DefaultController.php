<?php

namespace app\modules\m\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class DefaultController extends \app\core\web\MController
{
//    public $layout = "@app/modules/m/views/layouts/m.php";

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * @name 路线导航
     */
    public function actionRoute()
    {
        return $this->render('route');
    }



}
