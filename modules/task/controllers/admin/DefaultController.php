<?php

namespace app\modules\task\controllers\admin;

use Yii;
use app\modules\task\models\Task;
use app\modules\task\models\search\TaskSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Task model.
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
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $params = Yii::$app->request->queryParams;


        $dataProvider = $searchModel->search($params);

        if (isset($params['excel']) && $params['excel']){
            return $this->excel($dataProvider);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    private function excel($dp)
    {

        $columns = [
            'info.name',
            'user.username',
            'op.username',
            'title',
            'content:ntext',
            'pre_finish:date',
            'finish',
            'statusText',
        ];

        $options = [
            'title'=>'任务',
            'filename'=>'task',
            'pageTitle'=>'任务'
        ];
        \app\core\libs\Export::export($dp, $columns, $options);
    }

    /**
     * Displays a single Task model.
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
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Task();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $model->pre_finish = date('Y-m-d', strtotime('+2 day'));
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {

            $model->pre_finish = substr($model->pre_finish, 0,10);
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $flag = $model->del();

        if (Yii::$app->request->isAjax) {
            
            if ($flag) {
                return $this->json();
            } else {
                return $this->json(null, '错误，请重试', 0);
            }
        }

        return $this->redirect(['index']);
    }

    public function actionFinish($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax) {

            if ($model->finish()) {
                return $this->json();
            } else {
                return $this->json(null, '错误，请重试', 0);
            }
        } else {
            $model->finish();
        }
        
        return $this->redirect(['index']);
    }


    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
