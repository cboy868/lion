<?php

namespace app\modules\analysis\controllers\admin;

use Yii;
use app\modules\analysis\models\Settlement;
use app\modules\analysis\models\SettlementSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use app\modules\order\models\Pay;

use app\core\helpers\Url;
/**
 * FinanceController implements the CRUD actions for Settlement model.
 */
class FinanceController extends BackController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'check' => ['post']
                ],
            ],
        ];
    }

    /**
     * Lists all Settlement models.
     * @return mixed
     * @name 财务报表
     */
    public function actionIndex()
    {   

        // $pay = Pay::findOne(11);//order_id = 15

        // Settlement::create($pay);

        $searchModel = new SettlementSearch();
        $params = Yii::$app->request->queryParams;

        if (isset($params['today'])) {
            $params['SettlementSearch']['settle_time'] = date('Y-m-d');
        }

        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'get' => Yii::$app->request->get(),
        ]);
    }

    /**
     * @return \yii\web\Response
     * @name 财务结账
     */
    public function actionCheck()
    {
        Settlement::check();
        return $this->redirect(['index']);
    }

    /**
     * Displays a single Settlement model.
     * @param integer $id
     * @return mixed
     */
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }

    /**
     * Creates a new Settlement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new Settlement();
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
     * Updates an existing Settlement model.
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
     * Deletes an existing Settlement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Settlement::STATUS_DELETE;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Settlement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Settlement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Settlement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
