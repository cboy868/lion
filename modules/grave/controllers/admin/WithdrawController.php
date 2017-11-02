<?php

namespace app\modules\grave\controllers\admin;

use app\modules\grave\models\Customer;
use app\modules\grave\models\OrderRel;
use app\modules\grave\models\Tomb;
use app\modules\order\models\Refund;
use Yii;
use app\modules\grave\models\Withdraw;
use app\modules\grave\models\search\WithdrawSearch;
use app\core\web\BackController;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\grave\models\Grave;


/**
 * WithdrawController implements the CRUD actions for Withdraw model.
 */
class WithdrawController extends BackController
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
     * Lists all Withdraw models.
     * @return mixed
     * @name 退墓列表
     */
    public function actionIndex()
    {
        $searchModel = new WithdrawSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @name 退墓
     */
    public function actionCreate($tomb_id, $type)
    {
        $tomb = Tomb::findOne($tomb_id);
        $customer = Customer::findOne($tomb->customer_id);

        $model = new Withdraw();
        $model->guide_id = $tomb->guide_id;
        $model->tomb_id = $tomb_id;
        $model->user_id = $tomb->user_id;
        $model->status = $type;

        //找到曾付款
        $orel = OrderRel::find()->where([
            'tid'=>$tomb_id,
            'type'=>OrderRel::TYPE_TOMB,
            'status'=>OrderRel::STATUS_NORMAL,
            'is_refund' => 0
        ])->one();


        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $outerTransaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->price) {
                    $intro[] = [
                        'rel_id' => $orel->id,
                        'name' => $orel->title,
                        'num' => 1,
                        'price' => $model->price,
                    ];

                    $data = [
                        'user_id' => $model->user_id,
                        'order_id'=> $orel->order->id,
                        'intro'   => json_encode($intro),
                        'op_id'   => Yii::$app->user->id,
                        'fee'     => $model->price,
                        'tid'     => $tomb_id
                    ];

                    $refund = new Refund();
                    $refund->load($data, '');
                    $refund->save();

                    $model->refund_id = $refund->id;
                }

                if ($model->in_tomb_id) {
                    $inTomb = Tomb::findOne($model->in_tomb_id);
                    $inTomb->user_id = $tomb->user_id;
                    $inTomb->customer_id = $tomb->customer_id;
                    $inTomb->status = $tomb->status;
                    $inTomb->agent_id = $tomb->agent_id;
                    $inTomb->guide_id = $tomb->guide_id;
                    $inTomb->agency_id = $tomb->agency_id;
                    $inTomb->sale_time = date('Y-m-d H:i:s');
                    $inTomb->save();

                }

                $newTomb = $tomb->copy($tomb_id);

                $tomb->status = Tomb::STATUS_RETURN;
                $tomb->new_id = $newTomb->id;
                $tomb->save();

                $model->current_tomb_id = $newTomb->id;
                $model->save();

                $outerTransaction->commit();
            } catch (\Exception $e) {
                Yii::error($e->getMessage(), __METHOD__);
                $outerTransaction->rollBack();

            }
            return $this->redirect(['index']);
        }


        $model->ct_name = $customer->name;
        $model->ct_mobile = $customer->mobile;
        $model->ct_relation = $customer->relation;


        $graves = Grave::find()->where(['<>','status',Grave::STATUS_DELETE])
            ->andWhere(['is_leaf'=>1])
            ->all();
        $graves = ArrayHelper::map($graves, 'id', 'name');
        return $this->render('create',[
            'tomb' => $tomb,
            'type' => $type,
            'model' => $model,
            'oprice' => isset($orel->price) ? $orel->price : 0,
            'graves' => $graves
        ]);
    }

    /**
     * Displays a single Withdraw model.
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
     * Creates a new Withdraw model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     *
     */
//    public function actionCreate()
//    {
//        $model = new Withdraw();
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
     * Updates an existing Withdraw model.
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
     * Deletes an existing Withdraw model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

    /**
     * Finds the Withdraw model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Withdraw the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Withdraw::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
