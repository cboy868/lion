<?php

namespace app\modules\wechat\controllers\m;

use app\modules\wechat\models\User;
use yii;
use yii\web\NotFoundHttpException;

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
        $openid = $user->getId();

        $this->loginByOpenId($openid);

        $targetUrl = empty($session['target_url']) ? '/m' : $session['target_url'];
        header('location:'. $targetUrl);
    }

    private function loginByOpenId($openid)
    {
        $model = User::find()->where(['openid'=>$openid])->one();

        if (!$model) {
            throw new NotFoundHttpException('The requested wechat user does not exist.');
        }

        $session = Yii::$app->getSession();
        $session['wechat.user'] = $model;

        if ($model->user_id) {
            $model->login();
            $session['wechat.sys_user'] = Yii::$app->user;
        }
    }

}
