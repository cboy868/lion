<?php

namespace app\modules\ashes\controllers\admin;

use app\modules\ashes\models\Box;
use app\modules\grave\models\Dead;
use app\modules\grave\models\Tomb;
use Monolog\Handler\IFTTTHandler;
use Yii;
use app\modules\ashes\models\Log;
use app\modules\ashes\models\LogSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LogController implements the CRUD actions for Log model.
 */
class LogController extends BackController
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
     * Lists all Log models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Log model.
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
     * Creates a new Log model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($box_id)
    {
        $model = new Log();
        $box = Box::findOne(($box_id));

        if ($model->load(Yii::$app->request->post())) {

            $model->op_id = Yii::$app->user->id;
            $model->save_time = date('Y-m-d H:i:s');
            $model->save();

            $box->status = Box::STATUS_FULL;
            $box->log_id = $model->id;
            $box->save();

            Yii::$app->session->setFlash('success', '存入成功,柜号:'.$box->box_no);
            return $this->redirect(['/ashes/admin/default/index', 'box_id' => $model->box_id]);
        }


        $model->box_id = $box_id;
        $model->area_id = $box->area_id;
        $model->action = Log::ACTION_IN;


        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionTake($box_id)
    {
        $box = Box::findOne($box_id);

        if (!$box->log_id){
            Yii::$app->session->setFlash('error', '操作出错，或已经取出');

            return $this->redirect(['/ashes/admin/default/index']);
        }

        $log = $box->log;
        $note = $log->note;

        if ($log->load(Yii::$app->request->post()) && $log->save()) {

            Yii::$app->session->setFlash('success', '取盒操作成功');

            $box->log_id = 0;
            $box->status = Box::STATUS_EMPTY;
            $box->save();

            return $this->redirect(['/ashes/admin/default/view', 'box_id'=>$box_id]);
        }

        $log->out_time = date('Y-m-d H:i:s');
        $log->out_user = $log->save_user;

        return $this->renderAjax('take', ['log'=>$log]);
    }

    /**
     * Updates an existing Log model.
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

    public function actionTomb($grave_id, $row, $col)
    {
        $tomb = Tomb::find()->where(['grave_id'=>$grave_id, 'row'=>$row,'col'=>$col])
                            ->andWhere(['>', 'status', 0])
                            ->one();

        if (!$tomb) {
            return $this->json(null, '不存在此墓位', 0);
        }

        $data['tomb'] = $tomb->toArray();
        $customer = $tomb->customer;
        if ($customer) {
            $data['customer'] = $customer->toArray();
        }

        $deads = Dead::find()->where(['tomb_id'=>$tomb->id])
                            ->andWhere(['is_alive'=>0])
                            ->andWhere(['is', 'bury', NULL])
                            ->asArray()
                            ->all();
        if ($deads) {
            $data['deads'] = $deads;
        }

        return $this->json($data, null, 1);

    }

    /**
     * Deletes an existing Log model.
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
     * Finds the Log model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Log the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Log::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
