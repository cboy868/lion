<?php

namespace app\modules\user\controllers\m;

use app\core\helpers\ArrayHelper;
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

            $this->wechat_user = $session->get('wechat.wechat_user');
            if ($session->has('wechat.sys_user')) {
                $this->sys_user = $session->get('wechat.sys_user');
            }
            return true;
        }
    }


    public function actionIndex($wid)
    {
        p(ArrayHelper::toArray($this->wechat_user));die;
        return $this->render('index', [
            'wechat' => ArrayHelper::toArray($this->wechat_user)
        ]);
    }

    public function actionProfile()
    {
        return $this->render('profile', [
            'wechat' => ArrayHelper::toArray($this->wechat_user)
        ]);
    }

    /**
     * @return string
     * 账号
     */
    public function actionAccount()
    {
        return $this->render('account', [
            'wechat' => ArrayHelper::toArray($this->wechat_user)
        ]);
    }

    public function actionCreate()
    {
        return $this->render('create', [
            'wechat' => ArrayHelper::toArray($this->wechat_user)
        ]);
    }

    public function actionBind()
    {
        return $this->render('bind', [
            'wechat' => ArrayHelper::toArray($this->wechat_user)
        ]);
    }

    /**
     * @return string
     * @name 投诉建议
     */
    public function actionComplaint()
    {
        return $this->render('complaint', [
            'wechat' => ArrayHelper::toArray($this->wechat_user)
        ]);
    }

}
