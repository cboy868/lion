<?php

namespace app\modules\grave\controllers\admin;

use Yii;
use app\modules\grave\models\InsCfgRel;
use app\modules\grave\models\search\InsCfgRel as InsCfgRelSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InsCfgRelController implements the CRUD actions for InsCfgRel model.
 */
class InsCfgRelController extends BackController
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
     * Lists all InsCfgRel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InsCfgRelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InsCfgRel model.
     * @param integer $grave_id
     * @param integer $cfg_id
     * @return mixed
     */
    public function actionView($grave_id, $cfg_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($grave_id, $cfg_id),
        ]);
    }

    /**
     * Creates a new InsCfgRel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new InsCfgRel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'grave_id' => $model->grave_id, 'cfg_id' => $model->cfg_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing InsCfgRel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $grave_id
     * @param integer $cfg_id
     * @return mixed
     */
    public function actionUpdate($grave_id, $cfg_id)
    {
        $model = $this->findModel($grave_id, $cfg_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'grave_id' => $model->grave_id, 'cfg_id' => $model->cfg_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing InsCfgRel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $grave_id
     * @param integer $cfg_id
     * @return mixed
     */
    public function actionDelete($grave_id, $cfg_id)
    {
        $this->findModel($grave_id, $cfg_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the InsCfgRel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $grave_id
     * @param integer $cfg_id
     * @return InsCfgRel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($grave_id, $cfg_id)
    {
        if (($model = InsCfgRel::findOne(['grave_id' => $grave_id, 'cfg_id' => $cfg_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
