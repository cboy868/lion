<?php

namespace app\modules\m\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\core\helpers\Url;
use app\modules\memorial\models\Memorial;

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
        $oauth = $this->app->oauth;
        $session = Yii::$app->getSession();
        if (!$session->has('wuser')) {
            $session['target_url'] = Url::toRoute(['/m']);
            $oauth->redirect()->send();
        }

        p(Yii::$app->user->identity);die;

        //查找登录人的纪念馆
        $user_id = Yii::$app->user->id;
        $mems = Memorial::find()->where(['user_id'=>$user_id])->andWhere(['status'=>Memorial::STATUS_NORMAL])
                                ->all();

        return $this->render('index', ['memorial'=>$mems]);
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
