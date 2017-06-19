<?php
namespace app\modules\api\controllers\common;

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

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function behaviors() {

        $behaviors = parent::behaviors();

        $this->callback = Yii::$app->request->get('lcb',null);

        if ($this->callback) {
            $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSONP;

            Yii::$app->response->on(yii\web\Response::EVENT_BEFORE_SEND, function($event){
                $items = Yii::$app->response->data;
                $data = [
                    'data' => $items,
                    'callback' => $this->callback
                ];
                Yii::$app->response->data = $data;
            });
        }

        return $behaviors;
    }

    //	public function behaviors() {

//        $behaviors = ArrayHelper::merge (parent::behaviors(), [
//                'authenticator' => [
//                    'class' => QueryParamAuth::className()
//                ]
//        ]);
//
//        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_HTML;
//
//        return $behaviors;
//    }

    public function actions()
    {
        return [
            'index' => [
                'class' => 'app\modules\api\actions',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'view' => [
                'class' => 'app\modules\api\actions',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'create' => [
                'class' => 'app\modules\api\actions',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $this->createScenario,
            ],
            'update' => [
                'class' => 'app\modules\api\actions',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $this->updateScenario,
            ],
            'delete' => [
                'class' => 'app\modules\api\actions',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'options' => [
                'class' => 'app\modules\api\actions',
            ],
        ];
    }


}
