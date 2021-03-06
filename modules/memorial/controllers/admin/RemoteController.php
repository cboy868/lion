<?php

namespace app\modules\memorial\controllers\admin;

use Yii;
use app\modules\memorial\models\Remote;
use app\modules\memorial\models\RemoteSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RemoteController implements the CRUD actions for Remote model.
 */
class RemoteController extends BackController
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

    public function actions()
    {
        return [
            'pl-upload' => [
                'class' => 'app\core\web\PluploadAction',
            ],
            'video-upload' => [
                'class' => 'app\core\web\PluploadVideoAction',
            ]
        ];
    }

    public function saveAttach($info)
    {
        $remote = Remote::findOne($info['res_id']);

        if (!$remote) {
            return null;
        }

        return $remote->saveAttach($info);
    }

    public function saveVideo($info)
    {
        $remote = Remote::findOne($info['res_id']);

        if (!$remote) {
            return null;
        }

        return $remote->saveVideo($info);
    }

    /**
     * Lists all Remote models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RemoteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Remote model.
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
     * Creates a new Remote model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Remote();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionVideo($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('video', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Remote model.
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
     * Deletes an existing Remote model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionFinish($id)
    {
        $model = $this->findModel($id);
        $model->status = Remote::STATUS_OK;
        $model->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Remote model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Remote the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Remote::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
