<?php
namespace api\common\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Response;
use yii\data\ActiveDataProvider;

use api\common\models\NewsPhoto;
/**
 * Site controller
 */
class NewsController extends Controller
{
	public $modelClass = 'api\common\models\News';


    public function actionList($limit=5, $thumbSize='')
    {

    	if ($this->callback) {
    		Yii::$app->response->format = Response::FORMAT_JSONP;
    	}

    	$limit = $limit > 20 ? 20 : $limit;

    	$model = $this->modelClass;
        $items = $model::find()->where(['status'=>$model::STATUS_ACTIVE])->limit($limit)->asArray()->all();

        foreach ($items as $k => &$v) {
        	$v['cover'] = $this->imgBaseUrl . NewsPhoto::getById($v['thumb'], $thumbSize);
        	// $v['link'] = Url::toRoute(['/news', 'id'=>$v['id']]);
        }unset($v);

        if($this->callback){
		    return array(
				'callback' => $this->callback,
				'data' => $items
		    );
		}

        return $items;
    }





	// public function checkAccess($action, $model = null, $params = [])
	// {
	//     // 检查用户能否访问 $action 和 $model
	//     // 访问被拒绝应抛出ForbiddenHttpException 
	//     if ($action === 'index' || $action === 'delete') {
	//         if ($model->author_id !== \Yii::$app->user->id)
	//             throw new \yii\web\ForbiddenHttpException(sprintf('You can only %s articles that you\'ve created.', $action));
	//     }
	// }


	// public function actions()
	// {
	//     $actions = parent::actions();

	//     // 禁用"delete" 和 "create" 动作
	//     //unset($actions['delete'], $actions['create']);

	//     // 使用"prepareDataProvider()"方法自定义数据provider 
	//     $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

	//     return $actions;
	// }


	// public function prepareDataProvider()
	// {
	// 	return [1,2,3];
	// }
}
