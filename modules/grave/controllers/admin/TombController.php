<?php

namespace app\modules\grave\controllers\admin;

use Yii;
use app\modules\grave\models\Grave;
use app\modules\grave\models\Tomb;
use app\modules\grave\models\TombSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use app\modules\grave\models\TombForm;

/**
 * TombController implements the CRUD actions for Tomb model.
 */
class TombController extends BackController
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
     * Lists all Tomb models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TombSearch();
        $params = Yii::$app->request->queryParams;

        $params['TombSearch']['grave_id'] = $params['grave_id'];
        $dataProvider = $searchModel->search($params);

        $grave = Grave::findOne($params['grave_id']);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'grave' => $grave
        ]);
    }

    /**
     * Displays a single Tomb model.
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
     * Creates a new Tomb model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new TombForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->create()) {

            return $this->redirect(['index', 'grave_id' => $model->grave_id]);
            
        } else {

            $grave_id = Yii::$app->request->get('grave_id');

            if ($grave_id) {
                $model->grave_id = $grave_id;
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Tomb model.
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
     * Deletes an existing Tomb model.
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
     * Finds the Tomb model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tomb the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tomb::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
