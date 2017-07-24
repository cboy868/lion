<?php

namespace app\modules\client\controllers\admin;

use Yii;
use app\modules\client\models\Client;
use app\modules\client\models\ClientSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Client model.
 */
class DefaultController extends BackController
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
     * Lists all Client models.
     * @return mixed
     * @name 客户列表
     */
    public function actionIndex()
    {
        $searchModel = new ClientSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Client model.
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
     * Creates a new Client model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 添加新客户
     */
    public function actionCreate()
    {
        $model = new Client();

        $comfrom = $this->module->params['come_from'];

        if ($model->load(Yii::$app->request->post())) {

            $model->created_by = Yii::$app->user->id;
            if (!$model->come_from) {
                $model->come_from = 0;
            }
            if ($model->save()) {
                return $this->redirect(['/client/admin/recep/index', 'id'=>$model->id]);
            }
        }

        $model->loadDefaultValues();
        $model->guide_id = Yii::$app->user->id;
        return $this->render('create', [
            'model' => $model,
            'from'  => $comfrom
        ]);
    }

    /**
     * Updates an existing Client model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @name 修改客户信息
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $comfrom = $this->module->params['come_from'];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'from'  => $comfrom
            ]);
        }
    }

    /**
     * Deletes an existing Client model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除客户
     * @des 假删
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Client::STATUS_DELETE;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Client::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
