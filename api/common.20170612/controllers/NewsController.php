<?php
namespace api\common\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

use api\common\models\NewsPhoto;
use api\common\models\NewsCategory;
/**
 * Site controller
 */
class NewsController extends Controller
{
	public $modelClass = 'api\common\models\News';

    public $serializer = 'yii\rest\Serializer';

	public function behaviors() {
		return parent::behaviors();
    }

    public function actions() {  
        $actions = parent::actions();  
        // 禁用""index,delete" 和 "create" 操作  
        unset($actions['delete'], $actions['create'], $actions['view']);  
          
        return $actions;  
    } 

    public function actionList($limit=5, $thumbSize='')
    {

    	$condition = Yii::$app->request->get('condition');
    	$limit = $limit > 20 ? 20 : $limit;


    	$model = $this->modelClass;
    	$query = $model::find()->where(['status'=>$model::STATUS_ACTIVE])->limit($limit);
    	if (is_array($condition) && in_array('recommend', $condition)) {
    		$query->andFilterWhere(['recommend'=>1]);
    	}

    	if (is_array($condition) && in_array('top', $condition)) {
    		$query->andFilterWhere(['is_top'=>1]);
    	}
        $items = $query->asArray()->all();

        foreach ($items as $k => &$v) {
        	$v['cover'] = $this->imgBaseUrl . NewsPhoto::getById($v['thumb'], $thumbSize);
        	$v['created_date'] = date('Y-m-d H:i', $v['created_at']);
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

    public function actionCates()
    {
    	$items = NewsCategory::find()->where(['status'=>NewsCategory::STATUS_ACTIVE])
    								->select(['id', 'name'])
    								->all();


    	if($this->callback){
		    return array(
				'callback' => $this->callback,
				'data' => $items
		    );
		}

    	return $items;
    }

    public function actionClist($cid, $page=1, $pageSize=20, $order='created_at desc', $thumbSize="36x36")
    {
    	$model = $this->modelClass;

    	$query = $model::find()->where(['status'=>$model::STATUS_ACTIVE, 'category_id'=>$cid]);
    	$count = $query->count();

    	$pagination = new Pagination(['totalCount'=>$count, 'pageSize'=>$pageSize]);
    	$items = $query->offset($pagination->offset)
    					->orderBy($order)
    					->limit($pagination->limit)
    					->asArray()
    					->all();

    	foreach ($items as $k => &$item) {
    		$item['created_date'] = date('Y-m-d H:i', $item['created_at']);
    		$item['cover'] = $this->imgBaseUrl . NewsPhoto::getById($item['thumb'], $thumbSize);
    	}unset($item);

        if($this->callback){
		    return [
				'callback' => $this->callback,
				'data' => [
					'items' => $items,
					'pageCount' => $pagination->getPageCount(),
					'pageLinks' => $pagination->getLinks()
				]
		    ];
		}

        return $items;
    }

    public function actionView($id)
    {
    	$model = $this->modelClass;

    	$query = $model::findOne($id);
    	$body = $query->body;
    	$item = $query->toArray();
    	if ($body) {
    		$item['body'] = $body->body;
    	}
    	if($this->callback){
		    return [
				'callback' => $this->callback,
				'data' => $item
		    ];
		}

        return $item;
    }

    /**
     * @name 获取推荐的文章
     */
    public function actionRecommend()
    {

    }

    public function fields()
	{
	    return [
	        // 字段名和属性名相同
	        'id',
	        // 字段名为"email", 对应的属性名为"email_address"
	        'name' => '分类名'
	        // 字段名为"name", 值由一个PHP回调函数定义
	    ];
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
