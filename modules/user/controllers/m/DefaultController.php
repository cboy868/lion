<?php

namespace app\modules\user\controllers\m;

use yii;
use app\core\helpers\Url;
class DefaultController extends \app\core\web\MController
{


    public function beforeAction($action)
    {
        if (parent::beforeAction($action)){
            $this->initWechat();
            $session = Yii::$app->getSession();
            p($session['u']);
            p(Yii::$app->user->id);
            p($session['ws3']);die;
            $session['ws3'] = null;

            return true;
        }
    }
//
//    public function init()
//    {
//        parent::init();
//
//p(Yii::$app->controller);die;
////        echo Yii::$app->controller;die;
////        echo Url::current();die;
////
////        $this->initWechat(Url::current());
////
////        $session = Yii::$app->getSession();
////
////        p(Yii::$app->user->id);
////
////        p($session['ws1']);die;
////
////        return true;
//    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionProfile()
    {
        return $this->render('profile');
    }

    /**
     * @return string
     * 账号
     */
    public function actionAccount()
    {
        return $this->render('account');
    }

    /**
     * @return string
     * @name 投诉建议
     */
    public function actionComplaint()
    {
        return $this->render('complaint');
    }

}
