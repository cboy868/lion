<?php

namespace app\modules\shop\controllers\admin;

use Yii;
use app\modules\shop\models\Goods;
use app\modules\shop\models\InventoryPurchase;
use app\modules\shop\models\search\InventoryPurchase as InventoryPurchaseSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
/**
 * InventoryPurchaseController implements the CRUD actions for InventoryPurchase model.
 */
class InventoryPurchaseController extends BackController
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
     * Lists all InventoryPurchase models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InventoryPurchaseSearch();
        $params = Yii::$app->request->queryParams;
        $params['InventoryPurchase']['status'] = InventoryPurchase::STATUS_NORMAL;
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InventoryPurchase model.
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
     * Creates a new InventoryPurchase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new InventoryPurchase();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $model->op_id = Yii::$app->user->id;
            $model->op_name = Yii::$app->user->identity->username;
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing InventoryPurchase model.
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
     * Deletes an existing InventoryPurchase model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        $model = $this->findModel($id);
        $model->status = InventoryPurchase::STATUS_DEL;
        $model->save();

        return $this->redirect(['index']);
    }

    public function actionGlist($sp=null, $bm=null, $name=null)
    {

        $get = Yii::$app->request->queryParams;

        $query = Goods::find()->andFilterWhere(['like','pinyin', $sp])
                              ->andFilterWhere(['like','serial',$bm])
                              ->andFilterWhere(['name'=>$name]);

        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize'=>10]);

        $list = $query->offset($pagination->offset)
                      ->limit($pagination->limit)
                      ->all();

        return $this->renderAjax('glist', [
                'list' => $list,
                'pagination' => $pagination
            ]);
    }

    /**
     * Finds the InventoryPurchase model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InventoryPurchase the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InventoryPurchase::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
