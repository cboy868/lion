<?php

namespace app\modules\approval\controllers\admin;

use Yii;
use app\modules\approval\models\ApprovalLeave;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\approval\models\SearchApprovalLeave;
use app\core\helpers\ArrayHelper;
use app\modules\sys\models\SysLog;
/**
 * OvertimeController implements the CRUD actions for ApprovalOvertime model.
 */
class OvertimeController extends BackController
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
     * Lists all ApprovalOvertime models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchApprovalLeave();
        $params = Yii::$app->request->queryParams;
        if (isset($params['year'])) {
            $params['SearchApprovalLeave']['year'] = $params['year'];
        } else {
            $params['year'] = $params['SearchApprovalLeave']['year'] = date('Y');
        }

        if (isset($params['month'])) {
            $params['SearchApprovalLeave']['month'] = $params['month'];
        } else {
            $params['month'] = $params['SearchApprovalLeave']['month'] = date('m');
        }

        $params['SearchApprovalLeave']['genre'] = ApprovalLeave::GENRE_OVERTIME;

        $dataProvider = $searchModel->search($params);

        $cates = ApprovalLeave::find()->select(['year', 'month'])
            ->where(['<>', 'month', 0])
            ->andWhere(['genre'=>ApprovalLeave::GENRE_OVERTIME])
            ->orderBy('year desc, month desc')
            ->groupBy('year,month')
            ->asArray()
            ->all();

        $cates  = ArrayHelper::index($cates, 'month', 'year');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cates' => $cates,
            'params' => $params
        ]);
    }

    /**
     * Displays a single ApprovalOvertime model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }



    /**
     * Updates an existing ApprovalOvertime model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
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
     * Deletes an existing ApprovalOvertime model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionPass($id)
    {
        $model = $this->findModel($id);
        $model->status = ApprovalLeave::STATUS_PASS;

        if ($model->save() &&
            SysLog::create('overtime', $id, 'pass')) {
            return $this->json();
        }

        return $this->json(null, '操作出错，请重试', 0);
    }

    public function actionRefuse($id, $year=null, $month=null)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            SysLog::create('overtime', $id, 'refuse', $model->reason);
            Yii::$app->session->setFlash('success', '操作成功');
            return $this->redirect(['index','year'=>$year,'month'=>$month]);
        }

        $model->status = ApprovalLeave::STATUS_REFUSE;
        return $this->renderAjax('refuse', [
            'model' => $model
        ]);

    }

    /**
     * Finds the ApprovalOvertime model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ApprovalOvertime the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ApprovalLeave::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
