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
                $pay->on(Pay::EVENT_AFTER_PAY, [$pay->order, 'afterPay']);
                $pay->pay($v, $post['price'][$k]);
            }

            return $this->redirect(['view', 'id'=>$order->id]);
        }
        return $this->render('pay', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionRefund($id)
    {
        $refund = new Refund();
        $model = $this->findModel($id);


        if ($refund->load(Yii::$app->request->post())) {

            $post = Yii::$app->request->post();


            $items = $post['item'];

            $total = 0;
            $intro = '';
            foreach ($items as $k => $v) {
                $rel = OrderRel::findOne($k);
                $price = $rel->price_unit * $v;

                $total += $price;
                $intro .= $rel->title . ':' . $v . ':' . $price.';';
            }

            $data = [
                'user_id' => $model->user_id,
                'order_id'=> $model->id,
                'intro'   => $intro,
                'op_id'   => Yii::$app->user->id,
                'fee'     => $total,
            ];
            $refund->load($data, '');
            if ($refund->save()) {
                Yii::$app->session->setFlash('success', '宴请退款完成，待审批');
            }

        }

        return $this->render('refund',[
            'model'=>$model,
            'refund' => $refund
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
    public function actionCreate()
    {
        $model = new Order();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

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
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

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
