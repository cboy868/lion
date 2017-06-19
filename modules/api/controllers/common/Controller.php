<?php
namespace app\modules\api\controllers\common;

use app\core\helpers\ArrayHelper;
use Yii;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\filters\Cors;
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

        return ArrayHelper::merge([
            [
                'class' => Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                ]
            ],
        ], $behaviors);
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
                'class' => 'app\modules\api\actions\IndexAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'view' => [
                'class' => 'app\modules\api\actions\ViewAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'create' => [
                'class' => 'app\modules\api\actions\CreateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $this->createScenario,
            ],
            'update' => [
                'class' => 'app\modules\api\actions\UpdateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $this->updateScenario,
            ],
            'delete' => [
                'class' => 'app\modules\api\actions\DeleteAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'options' => [
                'class' => 'app\modules\api\actions\OptionsAction',
            ],
        ];
    }

}
