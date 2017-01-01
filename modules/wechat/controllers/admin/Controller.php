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
	protected $wechat;

	public function init()
	{
		$params = Yii::$app->params['wechat']['wx'];

		$options = [
			'debug'  => true,
			'log' => [
				'level' => 'debug',
				'file'  => Yii::getAlias('@app/web/logs'), // XXX: 绝对路径！！！！
			],
		];

		$options['app_id'] = $params['appid'];
		$options['secret'] = $params['appsecret'];
		$options['token']  = $params['token'];

		$this->wechat = new Application($options);

		parent::init();
	}
	
}
