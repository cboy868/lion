<?php

namespace app\modules\shop\controllers\admin;

use app\modules\shop\models\Sku;
use Yii;
use app\modules\shop\models\InventoryStorage;
use app\modules\shop\models\search\InventoryStorage as InventoryStorageSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\shop\models\InventoryStorageRel;
use app\modules\shop\models\search\InventoryStorageRel as InventoryStorageRelSearch;
/**
 * InventoryStorageController implements the CRUD actions for InventoryStorage model.
 */
class InventoryStorageController extends BackController
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
     * Lists all InventoryStorage models.
     * @return mixed
     */
    public function actionIndex()
    {



        $searchModel = new InventoryStorageSearch();
        $params = Yii::$app->request->queryParams;
        $params['InventoryStorage']['status'] = InventoryStorage::STATUS_NORMAL;
        $dataProvider = $searchModel->search($params);

        $data = [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];

        $id = Yii::$app->request->get('id');
        if ($id) {
            $params['InventoryStorageRelSearch']['storage_id'] = $id;
            $relSearchModel = new InventoryStorageRelSearch();
            $relDataProvider = $relSearchModel->search($params);
            $data['relDataProvider'] = $relDataProvider;
        }

        return $this->render('index', $data);
    }

    /**
     * @name 同步
     */
    public function actionSync($storage)
    {
        $skus = Sku::find()->where(['NOT', ['num' => null]])->asArray()->all();

        $st = InventoryStorage::findOne($storage);

        Yii::$app->db->createCommand()
            ->delete(InventoryStorageRel::tableName(),[
                'storage_id' => $storage,
            ])
            ->execute();

        foreach ($skus as $v) {
            $st->add($v['goods_id'], $v['id'], $v['num']);
        }

        return $this->redirect(['index', 'id'=>$storage]);

    }

    /**
     * Displays a single InventoryStorage model.
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
     * Creates a new InventoryStorage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new InventoryStorage();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing InventoryStorage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing InventoryStorage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = InventoryStorage::STATUS_DEL;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the InventoryStorage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InventoryStorage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InventoryStorage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
