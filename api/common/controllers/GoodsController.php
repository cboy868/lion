<?php
namespace api\common\controllers;

use Yii;
use yii\rest\ActiveController;
use api\common\models\Goods;
use api\common\models\GoodsCategory;
use yii\data\Pagination;
use app\core\models\Attachment;
use api\common\models\GoodsAvRel;
use api\common\models\GoodsAttr;
use api\common\models\GoodsSku;
use yii\helpers\ArrayHelper;
/**
 * Site controller
 */
class GoodsController extends Controller
{
	public $modelClass = 'api\common\models\Goods';

    public function actions() {  
        $actions = parent::actions();  
        // 禁用""index,delete" 和 "create" 操作  
        unset($actions['delete'], $actions['create'], $actions['view']);  
          
        return $actions;  
    } 

	public function actionList($limit=5, $thumbSize='')
    {
    	$limit = $limit > 20 ? 20 : $limit;

    	$model = $this->modelClass;
    	$query = $model::find()->where(['status'=>$model::STATUS_ACTIVE])
                               ->limit($limit)
                               ->indexBy('id');
    	
        $items = $query->asArray()->all();

        foreach ($items as $k => &$v) {
        	$v['cover'] = Attachment::getById($v['thumb'], $thumbSize);
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
    	$items = GoodsCategory::find()->where(['status'=>GoodsCategory::STATUS_ACTIVE])
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


    public function actionClist($cid, $page=1, $pageSize=20, $order='created_at desc', $thumbSize="400x400")
    {
        $model = $this->modelClass;

        $query = $model::find()->where(['status'=>$model::STATUS_ACTIVE, 'category_id'=>$cid]);
        // $query->andWhere(['<>', 'price', '0']);

        $count = $query->count();

        $pagination = new Pagination(['totalCount'=>$count, 'pageSize'=>$pageSize]);
        $items = $query->offset($pagination->offset)
                        ->orderBy($order)
                        ->limit($pagination->limit)
                        ->asArray()
                        ->all();

        foreach ($items as $k => &$item) {
            $item['created_date'] = date('Y-m-d H:i', $item['created_at']);
            $item['cover'] = Attachment::getById($item['thumb'], $thumbSize);
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
        $item = $query->toArray();

        //取出图片
        $imgs = $query->getImgs('790x620');
        if ($imgs) {
            $item['imgs'] = $imgs;
        }

        //取出规格
        $specs = $query->avRels;

        //取出sku
        $skus = GoodsSku::find()->where(['goods_id'=>$id])->indexBy('av')->asArray()->all();


        if($this->callback){
            return [
                'callback' => $this->callback,
                'data' => [
                    'item' => $item,
                    'specs' => $specs['spec'],
                    'skus' => $skus
                ]
            ];
        }
        return $item;
    }
}
