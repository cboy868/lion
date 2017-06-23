<?php

namespace app\modules\shop\controllers\m;

use yii;
use app\modules\api\models\common\WechatUser;
use app\core\helpers\ArrayHelper;

class DefaultController extends \app\core\web\MController
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)){

//            if (!in_array($action->id, ['view','cart'])) {
//                return true;
//            }

            $this->initWechat();
            $session = Yii::$app->getSession();

            $wechat_user = $session->get('wechat.wechat_user');

            $this->wechat_user = WechatUser::findOne($wechat_user->id);
            if ($session->has('wechat.sys_user')) {
                $this->sys_user = $session->get('wechat.sys_user');
            }
            return true;
        }

        return false;
    }
	/**
	 * @name 商品首页
	 */
	public function actionIndex()
	{
		return $this->render('index', [
            'wechat' => ArrayHelper::toArray($this->wechat_user)
        ]);
	}

	/**
	 * @name 商品详情
	 */
	public function actionView()
	{
		$this->layout = "@app/modules/m/views/layouts/nofooter.php";
		return $this->render('view', [
			'get' => \Yii::$app->request->get(),
            'wechat' => ArrayHelper::toArray($this->wechat_user)
		]);
	}

	/**
	 * @name 购物车
	 */
	public function actionCart()
	{
		$this->layout = "@app/modules/m/views/layouts/nofooter.php";
		return $this->render('cart', [
            'wechat' => ArrayHelper::toArray($this->wechat_user)
        ]);
	}
}
