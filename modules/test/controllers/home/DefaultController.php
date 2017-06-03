<?php

namespace app\modules\test\controllers\home;

use yii;
use app\core\helpers\Html;

class DefaultController extends \app\core\web\HomeController
{
    public function init()
    {
        parent::init();

        Yii::$app->language = 'zh-CN';
    }
    public function actionIndex()
    {
    	// p($this->view->theme);die;
        return $this->render('index');
    }

    public function actionTest()
    {
        echo Yii::t('app', 'hello');

    }
}
