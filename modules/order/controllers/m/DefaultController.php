<?php

namespace app\modules\order\controllers\m;

use yii;
use app\modules\api\models\common\WechatUser;
use app\core\helpers\ArrayHelper;
class DefaultController extends \app\core\web\MController
{
    public $wechat_user = null;

    public $sys_user = null;

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)){
            $this->initWechat();
            $session = Yii::$app->getSession();

            $wechat_user = $session->get('wechat.wechat_user');

            $this->wechat_user = WechatUser::findOne($wechat_user->id);
            if ($session->has('wechat.sys_user')) {
                $this->sys_user = $session->get('wechat.sys_user');
            }
            return true;
        }
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'wechat' => ArrayHelper::toArray($this->wechat_user)
        ]);
    }

    public function actionView()
    {
    	return $this->render('view', [
    			'get' => Yii::$app->request->get()
    		]);
    }
}
