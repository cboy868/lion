<?php

namespace app\modules\mess\controllers\admin;

use app\modules\mess\models\MessStorage;
use Yii;
use app\modules\mess\models\MessStorageRecord;
use app\modules\mess\models\SearchMessStorageRecord;
use app\modules\mess\models\SearchMessStorage;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StorageController implements the CRUD actions for MessStorageRecord model.
 */
class StorageController extends BackController
{
    public static $types = [
        1=>'入库',
        2=>'出库'
    ];

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
     * @name 总库存
     */
    public function actionList()
    {
        $searchModel = new SearchMessStorage();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all MessStorageRecord models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchMessStorageRecord();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'types' => self::$types
        ]);
    }

    /**
     * Displays a single MessStorageRecord model.
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
     * Creates a new MessStorageRecord model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MessStorageRecord();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            MessStorage::up($model->mess_id, $model->food_id, $model->number, $model->type);
            return $this->redirect(['index']);
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MessStorageRecord model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $onum = $model->number;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            MessStorage::up($model->mess_id, $model->food_id, $model->number - $onum, $model->type);
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MessStorageRecord model.
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
     * Finds the MessStorageRecord model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MessStorageRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MessStorageRecord::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
