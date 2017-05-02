<?php
namespace api\common\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\data\ActiveDataProvider;
/**
 * Site controller
 */
class Controller extends ActiveController
{
	public $callback = null;

	public $imgBaseUrl = 'http://www.lion.cn';

	public function init()
	{
		$this->callback = Yii::$app->request->get('lcb',null);
	}


}
