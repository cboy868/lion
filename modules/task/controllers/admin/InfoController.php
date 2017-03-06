<?php

namespace app\modules\task\controllers\admin;

use Yii;
use app\modules\task\models\Info;
use app\modules\task\models\InfoForm;
use app\modules\task\models\User;

use app\modules\task\models\search\InfoSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\core\helpers\ArrayHelper;

/**
 * InfoController implements the CRUD actions for Info model.
 */
class InfoController extends BackController
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
     * Lists all Info models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Info model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Info model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new InfoForm();
        if ($model->load(Yii::$app->request->post())) {
            $info =  $model->create();
            return $this->redirect(['view', 'id' => $info->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'user' => $user,
            ]);
        }
    }

    /**
     * Updates an existing Info model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $form = new InfoForm();
        $model = $this->findModel($id);

// 'name' => '任务名',
//             'intro' => '介绍',
//             'msg' => '消息内容',
//             'created_at' => '添加时间',
//             'user' => '任务接收人',
//             'default' => '直接处理人'

        $form->name = $model->name;
        $form->intro = $model->intro;
        $form->msg = $model->msg;
        $form->default = $model->default->user_id;
        $selUsers = $model->users;

        $result = [];

        foreach ($selUsers as $k => $v) {
            $result[$v->user_id] = $v->user->username;
        }

        $form->user = array_keys($result);

        if ($form->load(Yii::$app->request->post())) {
            $info =  $model->create();

            return $this->redirect(['view', 'id' => $info->id]);
        } else {
            return $this->render('update', [
                'model' => $form,
                'sels' => $result
            ]);
        }
    }

    /**
     * Deletes an existing Info model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            $this->findModel($id)->delete();
            $connection->createCommand()->delete(User::tableName(), ['info_id'=>$id])->execute();
            $transaction->commit();

        } catch (\Exception $e) {
            $transaction->rollBack();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Info model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Info the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Info::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
