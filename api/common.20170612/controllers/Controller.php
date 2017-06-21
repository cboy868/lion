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

	public function behaviors() {

        $behaviors = parent::behaviors();

        // $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_HTML;

        $this->callback = Yii::$app->request->get('lcb',null);
        
        if ($this->callback) {
        	$behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSONP;	
        }

        return $behaviors;
    }


    public function actions()
    {
        return [
            'index' => [
                'class' => 'api\common\actions\IndexAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'view' => [
                'class' => 'api\common\actions\ViewAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'create' => [
                'class' => 'api\common\actions\CreateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $this->createScenario,
            ],
            'update' => [
                'class' => 'api\common\actions\UpdateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $this->updateScenario,
            ],
            'delete' => [
                'class' => 'api\common\actions\DeleteAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'options' => [
                'class' => 'api\common\actions\OptionsAction',
            ],
        ];
    }


}