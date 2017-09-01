<?php

namespace app\core\web;
use yii;
use app\core\helpers\Url;
use EasyWeChat\Foundation\Application;
use app\modules\wechat\models\Wechat;
use yii\web\NotFoundHttpException;
/**
 * Default controller for the `wechat` module
 */
class MController extends \app\core\web\Controller
{
//	public $layout = "@app/core/views/layouts/m.php";
    public $layout = "@app/modules/m/views/layouts/m.php";

    public $options = [];

    public $app = null;

    public $wid;

    public $wechat_user = null;

    public $sys_user = null;


//	public function beforeAction($action)
//    {
//        if (parent::beforeAction($action)) {
//            return true;
//        }
//    }

    public function init()
    {
        parent::init();

        Yii::$app->homeUrl = \yii\helpers\Url::toRoute(['/']);
        $this->_theme();

        $wid = Yii::$app->request->get('wid');
        $this->wid = $wid;
        if ($wid) {
            $this->setOptions($wid);
            $this->app = new Application($this->options);
        }
    }

    protected function initWechat()
    {

        if (!$this->app) {
            throw new NotFoundHttpException();
        }
        $oauth = $this->app->oauth;
        $session = Yii::$app->getSession();

        p($session->get('wechat.wechat_user'));die;

        if (!$session->has('wechat.wechat_user')) {

            $session['target_url'] = Url::current();

            $oauth->redirect()->send();
        }

    }

    protected function _theme() {

        $model = \app\modules\sys\models\Set::findOne('theme');

        $this->view->theme->pathMap = [
            '@app/modules/m/views/default' => '@app/web/theme/' . $model->svalue . '/mobile/home',
            '@app/modules/m/views/layouts' => '@app/web/theme/' . $model->svalue . '/mobile/layouts',
            '@app/modules/news/views/m/default' => '@app/web/theme/' . $model->svalue . '/mobile/news',
            '@app/modules/shop/views/m/default' => '@app/web/theme/' . $model->svalue . '/mobile/goods',

            '@app/modules/user/views/m/default' => '@app/web/theme/' . $model->svalue . '/mobile/user',
            '@app/modules/order/views/m/default' => '@app/web/theme/' . $model->svalue . '/mobile/order',

            '@app/modules/grave/views/m/default' => '@app/web/theme/' . $model->svalue . '/mobile/grave',
            '@app/modules/memorial/views/m/default' => '@app/web/theme/' . $model->svalue . '/mobile/memorial',

            '@app/modules/cms/views/m/default' => '@app/web/theme/' . $model->svalue . '/mobile/article',
        ];
    }

    protected function setOptions($wid)
    {
        $account = Wechat::findOne($wid);
        if (!$account) {
            throw new NotFoundHttpException('The requested wechat does not exist.');
        }

        $params  = Yii::$app->getModule('wechat')->params;

        $this->options = [
            'debug'  => $params['debug'],
            'log' => $params['log']
        ];

        $this->options['app_id'] = $account->appid;
        $this->options['secret'] = $account->appsecret;
        $this->options['token']  = $account->token;

        $this->options['oauth'] = $params['oauth'];
        $this->options['oauth']['callback'] = Url::toRoute(['/wechat/m/default/callback', 'wid'=>$wid], true);

    }
}
