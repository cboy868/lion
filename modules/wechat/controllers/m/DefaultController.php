<?php

namespace app\modules\wechat\controllers\m;


class DefaultController extends \app\core\web\MController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCallback()
    {

        $oauth = $this->app->oauth;

        $user = $oauth->user();
        $session = Yii::$app->getSession();
        $session['wechat.user'] = $user;

        $targetUrl = empty($session['target_url']) ? '/' : $session['target_url'];
        header('location:'. $targetUrl); // 跳转到 user/profile
    }

}
