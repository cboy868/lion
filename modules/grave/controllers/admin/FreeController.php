<?php

namespace app\modules\grave\controllers\admin;

use app\modules\user\models\User;
use Yii;
use app\modules\grave\models\Free;
use app\modules\grave\models\search\Free as FreeSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FreeController implements the CRUD actions for Free model.
 */
class FreeController extends BackController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'finish' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Free models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FreeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Free model.
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
     * Creates a new Free model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Free();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->op_id) {
                $user = User::findOne($model->op_id);
                $model->op_user = $user->username;
                $model->op_mobile = $user->mobile;
            }

            if ($model->save() !== false) {
                return $this->redirect(['index']);
            }
        }
        $model->loadDefaultValues();
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Free model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->op_id) {
                $user = User::findOne($model->op_id);
                $model->op_user = $user->username;
                $model->op_mobile = $user->mobile;
            }

            if ($model->save() !== false) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionFinish($id)
    {
        $model = $this->findModel($id);

        $model->status = Free::STATUS_FINISH;

        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Free model.
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
     * Finds the Free model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Free the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Free::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
