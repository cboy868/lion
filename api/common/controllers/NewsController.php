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

//    public $serializer = 'yii\rest\Serializer';


    public $prepareDataProvider = '_index';

    public function actions() {  
        $actions = parent::actions();  
        // 禁用""index,delete" 和 "create" 操作  
//        unset($actions['delete'], $actions['create'], $actions['view']);

//        $actions['index']['prepareDataProvider'] = [$this, '_index'];
        return $actions;  
    }

    /**
     * @name index
     * @des 本方法可代替actions 中indexAction中的 prepareDataProvider
     */
    public function _index()
    {}

    public function actionCates()
    {
        $items = NewsCategory::find()->where(['status'=>NewsCategory::STATUS_ACTIVE])
            ->select(['id', 'name'])
            ->all();

        return $items;
    }

    public function actionClist($cid, $page=1, $pageSize=1, $order='created_at desc', $thumbSize="36x36")
    {
        $model = $this->modelClass;

        $query = $model::find()->where(['status'=>$model::STATUS_ACTIVE, 'category_id'=>$cid]);
        $count = $query->count();

        $pagination = new Pagination(['totalCount'=>$count, 'pageSize'=>1]);
        $items = $query->offset($pagination->offset)
                        ->orderBy($order)
                        ->limit($pagination->limit)
                        ->asArray()
                        ->all();

        foreach ($items as $k => &$item) {
            $item['created_date'] = date('Y-m-d H:i', $item['created_at']);
            $item['cover'] = $this->imgBaseUrl . NewsPhoto::getById($item['thumb'], $thumbSize);
        }unset($item);


        return [
            'items' => $items,
            'pageCount' => $pagination->getPageCount(),
            'pageLinks' => $pagination->getLinks()
        ];

    }


}
