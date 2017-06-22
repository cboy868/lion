<?php

namespace app\modules\user\controllers\m;

use yii;
use app\core\helpers\Url;
class DefaultController extends \app\core\web\MController
{

    public $wechat_user = null;

    public $sys_user = null;

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)){
            $this->initWechat();
            $session = Yii::$app->getSession();


            $this->wechat_user = $session->get('wechat.user');

            if ($session->has('wechat.sys_user')) {
                $this->sys_user = $session->get('wechat.sys_user');
            }

            return true;
        }
    }


    public function actionIndex()
    {

        p($this->sys_user);die;
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
