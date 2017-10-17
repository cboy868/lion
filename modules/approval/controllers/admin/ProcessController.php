<?php

namespace app\modules\approval\controllers\admin;

use app\modules\approval\models\Approval;
use app\modules\approval\models\ApprovalCan;
use app\modules\approval\models\ApprovalProcessStep;
use app\modules\user\models\User;
use Yii;
use app\modules\approval\models\ApprovalProcess;
use app\modules\approval\models\SearchApprovalProcess;
use app\core\web\BackController;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProcessController implements the CRUD actions for ApprovalProcess model.
 */
class ProcessController extends BackController
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
     * Lists all ApprovalProcess models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchApprovalProcess();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ApprovalProcess model.
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
     * Creates a new ApprovalProcess model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ApprovalProcess();
        $step = new ApprovalProcessStep();
        $config= $this->module->params['approval_type'];
        $staffs = User::staffs();
        $staffs = ArrayHelper::map($staffs, 'id', 'username');

        if ($model->load(Yii::$app->request->post()) ) {
            $post = Yii::$app->request->post();

            $outerTransaction = Yii::$app->db->beginTransaction();
            try {
                $model->create_user = Yii::$app->user->id;

                if (!isset($post['ApprovalProcess']['can_user'])) {
                    $can_user = $staffs;
                } else {
                    $can_user = $post['ApprovalProcess']['can_user'];
                }
                $steps = $post['ApprovalProcessStep'];
                $steps_deal = [];
                $step_total = 0;
                foreach ($steps as $k=>$v) {
                    if (!isset($v['step_name']) || !isset($v['approval_user'])) {
                        continue;
                    }
                    $steps_deal[$k] = $v;
                    $step_total++;
                }
                if ($step_total <=1) {
                    throw new Exception('请填写至少一条完整流程审批步骤');
                }
                $model->can_user = implode(',', $can_user);
                $model->step_total = $step_total;
                $model->save();

                $can_model = new ApprovalCan();
                foreach ($can_user as $v) {
                    $can = clone $can_model;
                    $can->process_id = $model->id;
                    $can->user_id = $v;
                    $can->save();
                }

                foreach ($steps_deal as $v) {

                    $step_model = clone $step;
                    $step_model->process_id = $model->id;
                    $step_model->step = $v['step'];
                    $step_model->step_name = $v['step_name'];
                    $step_model->approval_user = implode(',', $v['approval_user']);
                    $step_model->save();
                }

                $outerTransaction->commit();

                return $this->redirect(['view', 'id' => $model->id]);
            } catch (\Exception $e) {
                Yii::error($e->getMessage());
                Yii::$app->session->setFlash('error',$e->getMessage());
                $outerTransaction->rollBack();
            }
        }
        return $this->render('create', [
            'model' => $model,
            'step' => $step,
            'types' => $config,
            'staffs'=> $staffs
        ]);
    }

    /**
     * Updates an existing ApprovalProcess model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $step = new ApprovalProcessStep();
        $config= $this->module->params['approval_type'];
        $staffs = User::staffs();
        $staffs = ArrayHelper::map($staffs, 'id', 'username');

        $stepval = ApprovalProcessStep::find()
            ->where(['process_id'=>$id])
            ->indexBy('step')
            ->asArray()
            ->all();

        $cans = $model->cans;
        $can_user = [];
        foreach ($cans as $v) {
            $can_user[] = $v->user->id;
        }

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            $outerTransaction = Yii::$app->db->beginTransaction();
            try {

                if (!isset($post['ApprovalProcess']['can_user'])) {
                    $can_user = $staffs;
                } else {
                    $can_user = $post['ApprovalProcess']['can_user'];
                }
                $steps = $post['ApprovalProcessStep'];
                $steps_deal = [];
                $step_total = 0;
                foreach ($steps as $k=>$v) {
                    if (!isset($v['step_name']) || !isset($v['approval_user'])) {
                        continue;
                    }
                    $steps_deal[$k] = $v;
                    $step_total++;
                }
                if ($step_total <=1) {
                    throw new Exception('请填写至少一条完整流程审批步骤');
                }
                $model->can_user = implode(',', $can_user);
                $model->step_total = $step_total;
                $model->save();

                //原有数据全部删除
                Yii::$app->db->createCommand()
                    ->delete(ApprovalCan::tableName(),[
                        'process_id' => $model->id
                    ])
                    ->execute();

                $can_model = new ApprovalCan();
                foreach ($can_user as $v) {
                    $can = clone $can_model;
                    $can->process_id = $model->id;
                    $can->user_id = $v;
                    $can->save();
                }

                //原有数据全部删除
                Yii::$app->db->createCommand()
                    ->delete(ApprovalProcessStep::tableName(),[
                        'process_id' => $model->id
                    ])
                    ->execute();
                foreach ($steps_deal as $v) {
                    $step_model = clone $step;
                    $step_model->process_id = $model->id;
                    $step_model->step = $v['step'];
                    $step_model->step_name = $v['step_name'];
                    $step_model->approval_user = implode(',', $v['approval_user']);
                    $step_model->save();
                }

                $outerTransaction->commit();

                return $this->redirect(['view', 'id' => $model->id]);
            } catch (\Exception $e) {
                Yii::error($e->getMessage());
                Yii::$app->session->setFlash('error',$e->getMessage());
                $outerTransaction->rollBack();
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'step' => $step,
                'types' => $config,
                'staffs'=> $staffs,
                'stepval' => $stepval,
                'can_user' => $can_user
            ]);
        }
    }

    /**
     * Deletes an existing ApprovalProcess model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        $approval = Approval::find()->where(['process_id'=>$id])->one();

        if ($approval) {
            Yii::$app->session->setFlash('error', '该流程下已有审批内容，不可删除');
            return $this->redirect(['index']);
        }

        $model = $this->findModel($id);

        $model->delete();

        Yii::$app->db->createCommand()
            ->delete(ApprovalProcessStep::tableName(),[
                'process_id' => $model->id
            ])
            ->execute();

        //原有数据全部删除
        Yii::$app->db->createCommand()
            ->delete(ApprovalCan::tableName(),[
                'process_id' => $model->id
            ])
            ->execute();
        Yii::$app->session->setFlash('success', '审批流程删除成功');
        return $this->redirect(['index']);
    }

    /**
     * Finds the ApprovalProcess model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ApprovalProcess the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ApprovalProcess::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
