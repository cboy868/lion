<?php
namespace api\common\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\data\Pagination;

use api\common\models\Order;
use api\common\models\OrderRel;
use api\common\models\GoodsSku;
use api\common\models\GoodsCart;
use yii\filters\Cors;
/**
 * Site controller
 */
class OrderController extends Controller
{
	public $modelClass = 'api\common\models\Order';

    public function behaviors()
    {
        return ArrayHelper::merge([
            [
                'class' => Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                ]
            ],
        ], parent::behaviors());
    }

    public function actions() {  
        $actions = parent::actions();  
        // 禁用""index,delete" 和 "create" 操作  
        unset($actions['delete'], $actions['create'], $actions['view']);  
          
        return $actions;  
    }

    /**
     * @name 取订单列表
     * @des 为用户安全 使用post
     */
//    public function actionList()
//    {
//
//        $post = Yii::$app->request->post();
//
//        $user_id = $post['user'];
//        $page = isset($post['page']) ? $post['page'] : 1;
//        $pageSize = isset($post['pageSize']) ? $post['pageSize'] : 20;
//        $relThumbSize = isset($post['relThumbSize']) ? $post['relThumbSize'] : '100x100';
//
//
//        $model = $this->modelClass;
//
//        $query = $model::find()->where(['status'=>$model::STATUS_ACTIVE, 'user_id'=>$user_id]);
//        $count = $query->count();
//
//        $pagination = new Pagination(['totalCount'=>$count, 'pageSize'=>$pageSize]);
//        $items = $query->offset($pagination->offset)
//                        ->limit($pagination->limit)
//                        ->all();
//
//        $order_items = [];
//        foreach ($items as $item) {
//            $t = $item->toArray();
//            $t['created_date'] = date('Y-m-d H:i', $item['created_at']);
//
//            $rels = $item->rels;
//            $r = [];
//            foreach ($rels as $rel) {
//                $r[$rel['id']] = [
//                    'title' => $rel->title,
//                    'cover' => $rel->goods? $rel->goods->getCover($relThumbSize) : ''
//                ];
//            }
//            $t['rels'] = $r;
//
//            $order_items[] = $t;
//        }
//
//        $data = [
//            'items' => $order_items,
//            'pageCount' => $pagination->getPageCount()
//        ];
//        return $data;
//    }

    public function actionDel()
    {
        $post = Yii::$app->request->post();
        $order_id = $post['order_id'];

        $order = Order::findOne($post['order_id']);
        $order->status = Order::STATUS_DELETE;
        return $order->save();
    }

    /**
     * @name 订单详情
     */
    public function actionView($id, $thumb="")
    {

        $order = Order::findOne($id);
        $rels = $order->rels;

        //支付方式
        $pays = $order->pays;
        $pay_type = '';
        foreach ($pays as $k => $v) {
            $pay_type .= $v->method . ' ';
        }


        $order_data = $order->toArray();
        $order_data['created_date'] = date('Y-m-d H:i', $order_data['created_at']);
        $order_data['pay_type'] = $pay_type;
        $order_data['progress'] = $order->pro;

        $rels_data = [];
        foreach ($rels as $k => $v) {
            $rels_data[$v->id] = $v->toArray();
            $rels_data[$v->id]['cover'] = $v->goods->getCover($thumb);
        }

        $data = [
            'order' => $order_data,
            'rels' => $rels_data
        ];
        if($this->callback){
            return array(
                'callback' => $this->callback,
                'data' => $data
            );
        }

        return $data;
    }

    /**
     * @name 创建订单
     */
    public function actionBuy()
    {
        $post = Yii::$app->request->post();

        $user = $post['user'];
        $params = $post['params'];

        foreach ($params as $k => $v) {
            if (!$v['num'] || !$v['sku_id']) {
                continue;
            }
            GoodsCart::find()->where(['user_id'=>$user, 'sku_id'=>$v['sku_id']])->one()->delete();
            $sku = GoodsSku::findOne($v['sku_id']);
            $order = $sku->order($user, ['num'=>$v['num']]);
        }

        return $order;
    }

}
