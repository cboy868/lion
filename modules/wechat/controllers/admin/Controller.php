<?php
namespace app\modules\wechat\controllers\admin;

use Yii;
use app\modules\wechat\models\Wechat;
use yii\web\NotFoundHttpException;
use EasyWeChat\Foundation\Application;
/**
 * Site controller
 */
class Controller extends \app\core\web\BackController
{
    public $options = [];

    public $app = null;

    public $wid;

    public function init()
    {
        $session = Yii::$app->getSession();

        if (!$session->has('wechat.id')) {
            return $this->redirect(['/wechat/admin/account/index']);
        }
        $wid = $session->get('wechat.id');
        $this->wid = $wid;
        $this->setOptions($wid);
        $this->app = new Application($this->options);
    }




//	protected $wechat;
//
//	protected $current_wechat;
//
//	public function init()
//	{
//		$params = Yii::$app->params['wechat']['wx'];
//
//		$options = [
//			'debug'  => true,
//			'log' => [
//				'level' => 'debug',
//				'file'  => Yii::getAlias('@app/web/logs'), // XXX: 绝对路径！！！！
//			],
//		];
//
//		$options['app_id'] = $params['appid'];
//		$options['secret'] = $params['appsecret'];
//		$options['token']  = $params['token'];
//
//		$this->wechat = new Application($options);
//
//		parent::init();
//	}

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
    }
	
}
