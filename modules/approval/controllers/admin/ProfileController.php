<?php

namespace app\modules\approval\controllers\admin;

use app\core\helpers\ArrayHelper;
use app\modules\approval\models\ApprovalLeave;
use app\modules\approval\models\ApprovalLeaveForm;
use app\modules\approval\models\SearchApprovalLeave;
use app\modules\approval\models\SearchApprovalStep;
use app\modules\sys\models\SysLog;
use Yii;
use app\modules\approval\models\Approval;
use app\modules\approval\models\SearchApproval;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Approval model.
 * todo 还应该有替班
 */
class ProfileController extends \app\core\web\ProfileController
{
    /**
     * Lists all Approval models.
     * @return mixed
     */
    public function actionIndex()
    {





        return $this->render('index');
    }

    public function actionWork()
    {
        return $this->render('work');
    }

    /**
     * @return string
     * @name 请假
     */
    public function actionLeave()
    {
        $searchModel = new SearchApprovalLeave();
        $params = Yii::$app->request->queryParams;

        $params['SearchApprovalLeave']['created_by'] = Yii::$app->user->id;

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

        $dataProvider = $searchModel->search($params);

        $cates = ApprovalLeave::find()->select(['year', 'month'])
            ->where(['<>', 'month', 0])
            ->andWhere(['created_by'=>Yii::$app->user->id])
            ->orderBy('year desc, month desc')
            ->groupBy('year,month')
            ->asArray()
            ->all();

        $cates  = ArrayHelper::index($cates, 'month', 'year');

        return $this->render('leave', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cates' => $cates,
            'params' => $params
        ]);
    }

    public function actionLeaveView($id)
    {
        $model = ApprovalLeave::findOne($id);

        return $this->renderAjax('leave-view', [
            'model' => $model
        ]);
    }

    /**
     * @return string
     * @name 加班
     */
    public function actionOvertime()
    {
        return $this->render('overtime');
    }

    /**
     * @return string
     * @name 调休
     */
    public function actionAdjust()
    {
        return $this->render('adjust');
    }

    /**
     * @return string
     * @name 出差
     */
    public function actionTrip()
    {
        return $this->render('trip');
    }

    /**
     * @return string
     * @name 外出
     */
    public function actionOut()
    {
        return $this->render('out');
    }

    public function actionLeaveCreate()
    {
        $model = new ApprovalLeaveForm();

        if ($model->load(Yii::$app->request->post()) && $leave = $model->create()) {
            SysLog::create('leave', $leave->id, 'create');
            Yii::$app->session->setFlash('success', '请假申请提交完成，待审批');
            return $this->redirect(['leave']);
        }
        $model->type = 1;
        return $this->renderAjax('leave-create', [
            'model' => $model,
        ]);
    }

    public function actionLeaveUpdate($id)
    {
        $leave = ApprovalLeave::findOne($id);
        $model = new ApprovalLeaveForm();

        if ($model->load(Yii::$app->request->post()) && $model->update($leave)) {
            SysLog::create('leave', $id, 'update');
            Yii::$app->session->setFlash('success', '请假申请提交完成，待审批');
            return $this->redirect(['leave']);
        }
        $model->start = $leave->start_day . ' ' . $leave->start_time;
        $model->end = $leave->end_day . ' ' . $leave->end_time;
        $model->hours = $leave->hours;
        $model->desc = $leave->desc;
        $model->type = $leave->type;
        return $this->renderAjax('leave-update', [
            'model' => $model,
        ]);
    }

    public function actionLeaveUndo($id)
    {
        $model = ApprovalLeave::findOne($id);

        $model->status = $model->status == ApprovalLeave::STATUS_DRAFT ?
            ApprovalLeave::STATUS_NORMAL : ApprovalLeave::STATUS_DRAFT;

        if ($model->save()) {
            return $this->json(['statusText'=>$model->statusText]);
        }

        return $this->json(null, '操作失败，请重试', 0);
    }

    public function actionLeaveDelete($id)
    {
        $model = ApprovalLeave::findOne($id);

        if ($model->delete()) {
            return $this->json();
        } else {
            return $this->json(null, '删除失败,请重试', 0);
        }

    }


}
