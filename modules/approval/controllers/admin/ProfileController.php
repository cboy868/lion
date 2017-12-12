<?php

namespace app\modules\approval\controllers\admin;

use app\core\helpers\ArrayHelper;
use app\modules\approval\models\ApprovalAdjustForm;
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

    public static $genre_views = [
        ApprovalLeave::GENRE_LEAVE => 'leave',
        ApprovalLeave::GENRE_OVERTIME => 'overtime',
        ApprovalLeave::GENRE_ADJUST => 'adjust',
        ApprovalLeave::GENRE_OUT => 'out',
        ApprovalLeave::GENRE_TRIP => 'trip'
    ];
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
     * @param int $genre
     * @return string
     * @name 个人考勤 请假 加班 调休等
     */
    public function actionList($genre=ApprovalLeave::GENRE_LEAVE)
    {
        $searchModel = new SearchApprovalLeave();
        $params = Yii::$app->request->queryParams;

        $params['SearchApprovalLeave']['created_by'] = Yii::$app->user->id;
        $params['SearchApprovalLeave']['genre'] = $genre;

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
            ->andWhere(['genre'=>$genre])
            ->orderBy('year desc, month desc')
            ->groupBy('year,month')
            ->asArray()
            ->all();

        $cates  = ArrayHelper::index($cates, 'month', 'year');

        return $this->render(self::$genre_views[$genre], [
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

    public function actionLeaveCreate($genre)
    {
        $model = new ApprovalLeaveForm();

        if ($model->load(Yii::$app->request->post()) && $leave = $model->create()) {
            $res_name = $model->genre == ApprovalLeave::GENRE_LEAVE ? 'leave' : 'overtime';

            SysLog::create($res_name, $leave->id, 'create');
            Yii::$app->session->setFlash('success', '申请提交完成，待审批');

            return $this->redirect(['list', 'genre'=>$genre]);
        }
        $model->type = 1;
        $model->genre = $genre;
        return $this->renderAjax('leave-create', [
            'model' => $model,
        ]);
    }


    public function actionAdjustCreate()
    {
        $model = new ApprovalAdjustForm();

        if ($model->load(Yii::$app->request->post()) && $leave = $model->create()) {

            SysLog::create('adjust', $leave->id, 'create');

            Yii::$app->session->setFlash('success', '申请提交完成，待审批');

            return $this->redirect(['list', 'genre'=>ApprovalLeave::GENRE_ADJUST]);
        }
        $model->genre = ApprovalLeave::GENRE_ADJUST;
        return $this->renderAjax('adjust-create', [
            'model' => $model,
        ]);
    }

    public function actionLeaveUpdate($id)
    {
        $leave = ApprovalLeave::findOne($id);
        $model = new ApprovalLeaveForm();

        if ($model->load(Yii::$app->request->post()) && $model->update($leave)) {
            $res_name = $model->genre == ApprovalLeave::GENRE_LEAVE ? 'leave' : 'overtime';
            SysLog::create($res_name, $id, 'update');
            Yii::$app->session->setFlash('success', '申请提交完成，待审批');
            return $this->redirect(['list', 'genre'=>$model->genre]);
        }
        $model->start = $leave->start_day . ' ' . $leave->start_time;
        $model->end = $leave->end_day . ' ' . $leave->end_time;
        $model->hours = $leave->hours;
        $model->desc = $leave->desc;
        $model->type = $leave->type;
        $model->genre = $leave->genre;
        return $this->renderAjax('leave-update', [
            'model' => $model,
        ]);
    }


    public function actionAdjustUpdate($id)
    {
        $leave = ApprovalLeave::findOne($id);
        $model = new ApprovalAdjustForm();

        if ($model->load(Yii::$app->request->post()) && $model->update($leave)) {
            SysLog::create('adjust', $id, 'update');
            Yii::$app->session->setFlash('success', '申请提交完成，待审批');
            return $this->redirect(['list','genre'=>ApprovalLeave::GENRE_ADJUST]);
        }
        $model->start = $leave->start_day . ' ' . $leave->start_time;
        $model->end = $leave->end_day . ' ' . $leave->end_time;
        $model->hours = $leave->hours;
        $model->desc = $leave->desc;
        $model->type = $leave->type;
        $model->genre = $leave->genre;
        $model->overtime_ids = explode(',', $leave->overtime_ids);

        return $this->renderAjax('adjust-update', [
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
