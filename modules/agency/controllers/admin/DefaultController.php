<?php

namespace app\modules\agency\controllers\admin;

use app\modules\user\models\User;
use Yii;
use app\modules\agency\models\Agency;
use app\modules\agency\models\SearchAgency;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Agency model.
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
     * Lists all Agency models.
     * @return mixed
     * @name 办事处列表
     */
    public function actionIndex()
    {
        $searchModel = new SearchAgency();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Agency model.
     * @param integer $id
     * @return mixed
     * @name 办事处详细
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Agency model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 添加办事处
     */
    public function actionCreate()
    {
        $model = new Agency();

        if ($model->load(Yii::$app->request->post()) ) {

            if ($model->leader) {
                $user = User::findOne($model->leader);
                $model->mobile = $user->mobile;
            }

            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $model->loadDefaultValues();
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Agency model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @name 修改办事处
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Agency model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除办事处
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Agency::STATUS_DELETE;

        $model->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Agency model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Agency the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Agency::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
