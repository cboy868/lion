<?php
namespace app\modules\api\controllers\common;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\data\Pagination;


use app\modules\api\models\common\Cart;
use app\modules\api\models\common\Sku;
use app\modules\api\models\common\Order;
use yii\filters\Cors;
use yii\data\ActiveDataProvider;
/**
 * Site controller
 */
class OrderController extends Controller
{
	public $modelClass = 'app\modules\api\models\common\Order';

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


        $actions['index']['prepareDataProvider'] = [$this, '_index'];
        return $actions;
    }

    public function _index()
    {
        $params = Yii::$app->request->queryParams;

        $modelClass = $this->modelClass;

        $query = $modelClass::find()->orderBy('id desc');

        if (!isset($params['user_id'])) {
            return ['errno'=>1, 'error'=>'不合法的用户id'];
        }


        $query->andWhere(['user_id'=>$params['user_id']]);

        if (isset($params['status'])) {
            $query->andWhere(['status'=>$params['status']]);
        } else {
            $query->andWhere(['<>', 'status', $modelClass::STATUS_DELETE]);
        }




        $pageSize = 10;
        if (isset($params['pageSize'])) {
            $pageSize = $params['pageSize'];
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => new Pagination(['pageSize'=>$pageSize])
        ]);
    }

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
        $order_data['pro'] = $order->pro;

        $rels_data = [];
        foreach ($rels as $k => $v) {
            $rels_data[$v->id] = $v->toArray();
            if (!$v->goods){
                continue;
            }
            $rels_data[$v->id]['cover'] = self::$base_url . $v->goods->getCover($thumb);
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
            Cart::find()->where(['user_id'=>$user, 'sku_id'=>$v['sku_id']])->one()->delete();
            $sku = Sku::findOne($v['sku_id']);
            $order = $sku->order($user, ['num'=>$v['num']]);
        }

        return $order;
    }

    public function actionDirectBuy()
    {
        $post = Yii::$app->request->post();
        $sku_id = $post['sku_id'];
        if (!$sku_id) {
            return ['errno'=>1, 'msg'=>'请选择商品规格'];
        }
        $sku = Sku::findOne($sku_id);

        $order = $sku->order($post['user'], ['num'=>$post['num']]);

        return $order;
    }

}
