<?php

namespace app\modules\task\controllers\admin;

use Yii;
use app\modules\task\models\Goods;
use app\modules\task\models\search\GoodsSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GoodsController implements the CRUD actions for Goods model.
 */
class GoodsController extends BackController
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
     * Lists all Goods models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GoodsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Goods model.
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
     * Creates a new Goods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Goods();

        if ($model->load(Yii::$app->request->post()) ) {

            $msg_type = implode(',', $model->msg_type);

            foreach ($model->res_id[$model->res_name] as $k => $v) {
                $m = new Goods();
                $m->info_id = $model->info_id;
                $m->msg_type = $msg_type;
                $m->res_name = $model->res_name;
                $m->msg = $model->msg;
                $m->msg_time = $model->msg_time;
                $m->trigger = $model->trigger;
                $m->res_id = $v;

                $m->save();

                unset($m);
            }

            return $this->redirect(['index']);
        } else {
            $model->res_name = Goods::RES_CATEGORY;
            $model->trigger = Goods::TRIGGER_PAY;
            $model->msg_type = Goods::MSG_EMAIL;
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Goods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @todo 这里还有问题
     */
    public function actionUpdate($id)
    {


        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $msg_type = implode(',', $model->msg_type);

            foreach ($model->res_id[$model->res_name] as $k => $v) {
                $m = new Goods();
                $m->info_id = $model->info_id;
                $m->msg_type = $msg_type;
                $m->res_name = $model->res_name;
                $m->msg = $model->msg;
                $m->msg_time = $model->msg_time;
                $m->trigger = $model->trigger;
                $m->res_id = $v;

                $m->save();

                unset($m);
            }

            return $this->redirect(['index']);
        } else {

            $model->msg_type = explode(',', $model->msg_type);

            $model->res_id = [
                $model->res_name => $model->res_id,
            ];

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Goods model.
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
     * Finds the Goods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Goods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Goods::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}