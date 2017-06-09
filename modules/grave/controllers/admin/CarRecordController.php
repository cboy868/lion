<?php

namespace app\modules\grave\controllers\admin;

use app\modules\grave\models\Car;
use app\modules\grave\models\CarAddr;
use Yii;
use app\modules\grave\models\CarRecord;
use app\modules\grave\models\search\CarRecordSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CarRecordController implements the CRUD actions for CarRecord model.
 */
class CarRecordController extends BackController
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
     * Lists all CarRecord models.
     * @return mixed
     * @name 派车记录
     */
    public function actionIndex()
    {
        $searchModel = new CarRecordSearch();
        $params = Yii::$app->request->queryParams;

        $params['CarRecordSearch']['status'] = [CarRecord::STATUS_NORMAL, CarRecord::STATUS_COMPLETE];
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CarRecord model.
     * @param integer $id
     * @return mixed
     * @name 详细记录
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CarRecord model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 添加
     */
    public function actionCreate()
    {
        $model = new CarRecord();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CarRecord model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @name 修改
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
     * @name 完成操作
     */
    public function actionComplete($id)
    {
        $model = $this->findModel($id);
        $model->status = CarRecord::STATUS_COMPLETE;
        if ($model->save()) {
            Yii::$app->session->setFlash('success', '完成操作成功');
            //return $this->json();
        } else {
            Yii::$app->session->setFlash('error', '完成操作失败,请联系管理员');
        }
        return $this->redirect(['index']);

    }


    /**
     * Deletes an existing CarRecord model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除
     */
    public function actionDelete($id)
    {
        $model = CarRecord::findOne($id);
        $model->status = CarRecord::STATUS_NORMAL;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * @return array
     * 车辆检测
     */
    public function actionHasFreeCar()
    {
        $post = Yii::$app->request->post();
        $pre_bury_date = $post['pre_bury_date'];
        $addr = $post['addr'];
        $type = $post['type'];

        $addr_model = CarAddr::findOne($addr);
        if (!$addr_model) {
            return $this->json(null, '不存在此车辆', 0);
        }
        $long = $addr_model->time / 2;

        $start = date('Y-m-d H:i', strtotime("-".$long." minute", strtotime($pre_bury_date)));


        if (CarRecord::hasFreeCar($start, $addr_model->time, $type)) {
            return $this->json();
        }

        return $this->json(null, '本时段无可用车辆，请注意核实', 0);
    }

    /**
     * Finds the CarRecord model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CarRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CarRecord::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
