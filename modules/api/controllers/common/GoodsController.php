<?php
namespace app\modules\api\controllers\common;

use Yii;
use yii\rest\ActiveController;
use app\modules\shop\models\Category;
use yii\data\Pagination;
use app\core\models\Attachment;
use app\modules\shop\models\Sku;
use yii\helpers\ArrayHelper;
use yii\filters\Cors;
use app\modules\api\models\common\Cart;

/**
 * Site controller
 */
class GoodsController extends Controller
{
	public $modelClass = 'app\modules\api\models\common\Goods';

    public function actions() {
        $actions = parent::actions();
        // 禁用""index,delete" 和 "create" 操作
//        unset($actions['delete'], $actions['create']);

        $actions = array_merge($actions, [
            'recommend' => [
                'class' => 'app\modules\api\actions\RecommendAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
        ]);

        return $actions;
    }

    public function behaviors() {

        return parent::behaviors();
    }

//	public function actionList($limit=5, $thumbSize='')
//    {
//    	$limit = $limit > 20 ? 20 : $limit;
//
//    	$model = $this->modelClass;
//    	$query = $model::find()->where(['status'=>$model::STATUS_ACTIVE])
//                               ->limit($limit)
//                               ->indexBy('id');
//
//        $items = $query->asArray()->all();
//
//        foreach ($items as $k => &$v) {
//        	$v['cover'] = Attachment::getById($v['thumb'], $thumbSize);
//        	$v['created_date'] = date('Y-m-d H:i', $v['created_at']);
//        	// $v['link'] = Url::toRoute(['/news', 'id'=>$v['id']]);
//        }unset($v);
//
//
//        return $items;
//    }


    public function actionCates()
    {
    	$items = Category::find()->where(['status'=>Category::STATUS_ACTIVE])
    								->select(['id', 'name'])
    								->all();

    	return $items;
    }


//    public function actionClist($cid, $page=1, $pageSize=20, $order='created_at desc', $thumbSize="400x400")
//    {
//        $model = $this->modelClass;
//
//        $query = $model::find()->where(['status'=>$model::STATUS_ACTIVE, 'category_id'=>$cid]);
//        // $query->andWhere(['<>', 'price', '0']);
//
//        $count = $query->count();
//
//        $pagination = new Pagination(['totalCount'=>$count, 'pageSize'=>$pageSize]);
//        $items = $query->offset($pagination->offset)
//                        ->orderBy($order)
//                        ->limit($pagination->limit)
//                        ->asArray()
//                        ->all();
//
//        foreach ($items as $k => &$item) {
//            $item['created_date'] = date('Y-m-d H:i', $item['created_at']);
//            $item['cover'] = Attachment::getById($item['thumb'], $thumbSize);
//        }unset($item);
//
//
//        return ['items'=>$items, 'pageCount'=>$pagination->getPageCount()];
//    }

    /**
     * @name 购物车
     */
    public function actionCart()
    {
        $post = Yii::$app->request->post();
        $sku_id = $post['sku_id'];
        if (!$sku_id) {
            return ['errno'=>1, 'msg'=>'请选择商品规格'];
        }
        $sku = Sku::findOne($sku_id);
        $goods_model = $sku->goods;
        $result = Cart::create($post['user'],$sku_id, $goods_model,['num'=>$post['num']]);
        return $result;
    }

    public function actionCartList($thumbSize='64x64')
    {
        $post = Yii::$app->request->post();
        $list = Cart::find()->where(['user_id'=>$post['user']])
            ->indexBy('sku_id')
            ->asArray()
            ->all();

        $thumbSize = isset($post['thumbSize'])? $post['thumbSize'] : '64x64';
        $result = [];
        foreach ($list as $k => &$v) {
            $sku = Sku::findOne($v['sku_id']);
            $v['cover'] = self::$base_url . Attachment::getById($sku->goods->thumb, $thumbSize);
            $v['goods_name'] = $sku->goods->name;
            $v['sku_name'] = $sku->name;

            $v['price'] = $sku->price;
            $v['original_price'] = $sku->original_price;

        }unset($v);

        return $list;
    }

    public function actionCartGoods($thumbSize='64x64')
    {
        $post = Yii::$app->request->post();
        $list = Cart::find()->where(['user_id'=>$post['user']])
            ->indexBy('id')
            ->asArray()
            ->all();

        $thumbSize = isset($post['thumbSize'])? $post['thumbSize'] : '64x64';
        $result = [];
        foreach ($list as $k => &$v) {
            $sku = Sku::findOne($v['sku_id']);
            $v['cover'] = self::$base_url . Attachment::getById($sku->goods->thumb, $thumbSize);
            $v['goods_name'] = $sku->goods->name;
            $v['sku_name'] = $sku->name;

            $v['price'] = $sku->price;
            $v['original_price'] = $sku->original_price;

        }unset($v);

        return $list;
    }

    public function actionCartCount()
    {
        $get = Yii::$app->request->get();
        if (!isset($get['user'])) {
            return ['errno'=>1, 'msg'=>'参数错误'];
        }

        $query = Cart::find()->where(['user_id'=>$get['user']]);
        $type_num = $query->count();
        $goods_num = $query->sum('num');

        $total = 0;
        $o_total = 0;
        $list = $query->all();
        foreach ($list as $k => $v) {
            $total += $v->sku->price * $v->num;
            $o_total +=$v->sku->original_price * $v->num;
        }

        $data = [
            'goods_num' => $goods_num,
            'type_num'  => $type_num,
            'total' => $total,
            'o_total' => $o_total
        ];

        return $data;
    }

    public function actionUpdateCart()
    {
        $post = Yii::$app->request->post();
        $params = array_filter($post['params']);
        $user_id = $post['user'];

        foreach ($params as $k => $v) {
            $model = Cart::findOne($v['id']);
            $model->num = $v['num'];
            $model->save();
        }

        return true;
    }

    public function actionUpdateCartGoods()
    {
        $post = Yii::$app->request->post();
        $params = array_filter($post['params']);
        $user_id = $post['user'];

        $list = Cart::find()->where(['user_id'=>$user_id])->all();
        $list_ids = ArrayHelper::getColumn($list, 'id');
        $new_ids = ArrayHelper::getColumn($params,'id');
        $del_ids = array_diff($list_ids, $new_ids);

        return $del_ids;


        Yii::$app->db->createCommand()
            ->delete(Cart::tableName(),[
                'user_id' => $user_id,
            ])->execute();

        foreach ($params as $k => $v) {
            $model = Cart::findOne($v['id']);
            $model->num = $v['num'];
            $model->save();

            p($model->getErrors());
        }

        return true;
    }

    /**
     * @name 删除购物车商品
     */
    public function actionDelCart()
    {
        $post = Yii::$app->request->post();
        $user_id = $post['user'];
        $sku_id = $post['sku_id'];


        $model = Cart::find()->where(['user_id'=>$user_id])
                                  ->andWhere(['sku_id'=>$sku_id])
                                  ->one();
        return $model->delete();
    }
}
