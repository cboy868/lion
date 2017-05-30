<?php

namespace app\modules\order\controllers\admin;

use Yii;
use app\modules\order\models\Order;
use app\modules\order\models\OrderSearch;
use app\modules\order\models\OrderRel;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\order\models\Pay;
use app\modules\order\models\Delay;
use app\modules\order\models\OrderEvent;
use app\modules\order\models\Refund;

use app\core\helpers\ArrayHelper;
/**
 * DefaultController implements the CRUD actions for Order model.
 */
class DefaultController extends BackController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     * @name 订单详情
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @name 后台支付
     */
    public function actionPay($id)
    {
        $req = Yii::$app->request;
        if ($req->isPost) {
            $post = $req->post();

            $order_id = $post['order_id'];
            $order = Order::findOne($order_id);

            foreach ($post['pay_type'] as $k => $v) {
                if ($post['price'][$k] <= 0) {
                    continue;
                }
                $pay = Pay::create($order);

                if (!$pay) {
                    Yii::$app->session->setFlash('error', '创建支付记录出错，请联系管理员');
                    continue;
                }
                $pay->on(Pay::EVENT_AFTER_PAY, [$pay->order, 'afterPay']);
                $pay->on(Pay::EVENT_AFTER_PAY, [\app\modules\analysis\models\Settlement::className(), 'create'], ['pay'=>$pay]);
                
                if ($order->type == 5) {
                    $pay->on(Pay::EVENT_AFTER_PAY, [\app\modules\grave\models\Ins::className(), 'afterPay']);
                }
                
                $pay->pay($v, $post['price'][$k]);
            }

            return $this->redirect(['view', 'id'=>$order->id]);
        }
        return $this->render('pay', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @param $id
     * @return string
     * @name 退款
     */
    public function actionRefund($id)
    {
        $refund = new Refund();
        $model = $this->findModel($id);

        if ($refund->load(Yii::$app->request->post())) {

            $post = Yii::$app->request->post();


            $items = $post['item'];

            $total = 0;
            $intro = [];
            foreach ($items as $k => $v) {
                $rel = OrderRel::findOne($k);

                if ($v == 0) {
                    continue;
                }
                $price = $rel->price_unit * $v;

                $total += $price;

                $intro[] = [
                    'rel_id' => $k,
                    'name' => $rel->title,
                    'num' => $v,
                    'price' => $price,
                ];
                // $intro .= $rel->title . ':' . $v . ':' . $price.';';
            }

            $data = [
                'user_id' => $model->user_id,
                'order_id'=> $model->id,
                'intro'   => json_encode($intro),
                'op_id'   => Yii::$app->user->id,
                'fee'     => $total,
                'tid'     => isset($model->tid) ? $model->tid : 0
            ];
            $refund->load($data, '');
            if ($refund->save()) {
                Yii::$app->session->setFlash('success', '申请退款完成，待审批');
                return $this->redirect(['/order/admin/refund/index']);
            }
        }

        $rels = ArrayHelper::index($model->rels, 'id');

        $refunds = Refund::find()->where(['order_id'=>$id])
                                 ->andWhere(['<>', 'status', Refund::STATUS_DEL])
                                 ->andWhere(['<>', 'progress', Refund::PRO_NOPASS])
                                 ->all();


        foreach ($refunds as $k => $refund) {
            $intro = (array)json_decode($refund->intro, true);
            foreach ($intro as $item) {
                if (array_key_exists($item['rel_id'], $rels)) {
                    if ($item['num'] >= $rels[$item['rel_id']]['num']) {
                        unset($rels[$item['rel_id']]);
                    } else {
                        $rels[$item['rel_id']]->num -= $item['num'];
                    }
                }
            }
        }

        return $this->render('refund',[
            'model'=>$model,
            'refund' => $refund,
            'rels' => $rels
            ]);
    }



    /**
     * @name 延期支付申请
     */
    public function actionDelay($id)
    {

        $req = Yii::$app->request;
        $delay = new Delay();

        if ($req->isPost) {
            $post = $req->post();
            $order = Order::findOne($id);

            $delay->load(Yii::$app->request->post());

            $delay->on(Delay::EVENT_AFTER_CREATE, [$order, 'afterPay']);

            if ($delay->create($order)) {
                Yii::$app->session->setFlash('success', '延期付款申请完成，待审批...');
                return $this->redirect(['view', 'id'=>$id]);
            }

        }

        return $this->render('delay', [
            'model' => $this->findModel($id),
            'delay' => $delay
        ]);
    }

    

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new Order();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @name 修改价格
     */
    public function actionMPrice($id)
    {
        $model = OrderRel::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $order = $model->order->updatePrice();
            return $this->redirect(['view', 'id'=>$model->order_id]);
        }

        return $this->renderAjax('m-price', ['model'=>$model]);
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Order::STATUS_DELETE;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
