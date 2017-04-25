<?php

namespace app\modules\shop\controllers\admin;

use Yii;
use app\modules\shop\models\InventoryPurchase;
use app\modules\shop\models\InventoryPurchaseRel;
use app\modules\shop\models\search\InventoryPurchaseRel as InventoryPurchaseRelSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InventoryRelController implements the CRUD actions for InventoryPurchaseRel model.
 */
class InventoryRelController extends BackController
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
     * Lists all InventoryPurchaseRel models.
     * @return mixed
     */
    public function actionIndex($record_id)
    {
        $searchModel = new InventoryPurchaseRelSearch();

        $params = Yii::$app->request->queryParams;
        $params['InventoryPurchaseRel']['record_id'] = $record_id;
        $params['InventoryPurchaseRel']["status"] = InventoryPurchaseRel::STATUS_NORMAL;

        $dataProvider = $searchModel->search($params);

        $record = InventoryPurchase::findOne($record_id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'record' => $record
        ]);
    }

    public function actionRefund($id)
    {
        $model = $this->findModel($id);

        $model->status = InventoryPurchaseRel::STATUS_REFUND;
        $model->save();

        return $this->redirect(['index', 'record_id'=>$model->record_id]);
    }

    /**
     * Displays a single InventoryPurchaseRel model.
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
     * Creates a new InventoryPurchaseRel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new InventoryPurchaseRel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing InventoryPurchaseRel model.
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

    /**
     * Deletes an existing InventoryPurchaseRel model.
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
     * Finds the InventoryPurchaseRel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InventoryPurchaseRel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InventoryPurchaseRel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
