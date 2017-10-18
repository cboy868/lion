<?php

namespace app\modules\approval\controllers\member;

use app\modules\approval\models\ApprovalAttach;
use Yii;
use app\modules\approval\models\Approval;
use app\modules\approval\models\SearchApproval;
use app\core\web\MemberController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * DefaultController implements the CRUD actions for Approval model.
 */
class DefaultController extends MemberController
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
     * Lists all Approval models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchApproval();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPi()
    {
        $searchModel = new SearchApproval();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('pi', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Approval model.
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
     * Creates a new Approval model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Approval();

        if ($model->load(Yii::$app->request->post()) ) {

            $outerTransaction = Yii::$app->db->beginTransaction();
            try {
                $model->create_user = Yii::$app->user->id;
                $model->save();

                $uploads = UploadedFile::getInstancesByName('attach');
                if ($uploads) {
                    $config_path = $this->module->params['attach_path'];
                    $path = Yii::getAlias('@app/web/' . $config_path);
                    $path = $path . '/' . date('Y/m');

                    if (!is_dir($path)) {
                        @mkdir($path, 0777, true);
                    }

                    $attach = new ApprovalAttach();

                    foreach ($uploads as $upload) {
                        $file = uniqid().'.'.$upload->getExtension();
                        $file_name = $path . '/' . $file;
                        $upload->saveAs($file_name);

                        $n_attach = clone $attach;
                        $n_attach->approval_id = $model->id;
                        $n_attach->title = $upload->getBaseName();
                        $n_attach->url = Yii::getAlias('@web/'.$config_path.'/'.date('Y/m').'/'.$file);
                        $n_attach->ext = $upload->getExtension();
                        $n_attach->save();
                    }
                }

                $model->generateStep();

                $outerTransaction->commit();

                return $this->redirect(['view', 'id' => $model->id]);
            } catch (\Exception $e) {
                Yii::error($e->getMessage());
//                Yii::$app->session->setFlash('error',$e->getMessage());
                Yii::$app->session->setFlash('error','数据处理错误，请联系管理员');
                $outerTransaction->rollBack();
            }
        }


        $model->loadDefaultValues();
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Approval model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        //已上传附件
        $attachs = ApprovalAttach::find()->where(['approval_id'=>$id])->all();

        if ($model->load(Yii::$app->request->post())) {
            $outerTransaction = Yii::$app->db->beginTransaction();
            try {
                $model->progress = Approval::PRO_INIT;
                $model->save();

                $uploads = UploadedFile::getInstancesByName('attach');
                if ($uploads) {
                    $config_path = $this->module->params['attach_path'];
                    $path = Yii::getAlias('@app/web/' . $config_path);
                    $path = $path . '/' . date('Y/m');

                    if (!is_dir($path)) {
                        @mkdir($path, 0777, true);
                    }

                    $attach = new ApprovalAttach();

                    foreach ($uploads as $upload) {
                        $file = uniqid().'.'.$upload->getExtension();
                        $file_name = $path . '/' . $file;
                        $upload->saveAs($file_name);

                        $n_attach = clone $attach;
                        $n_attach->approval_id = $model->id;
                        $n_attach->title = $upload->getBaseName();
                        $n_attach->url = Yii::getAlias('@web/'.$config_path.'/'.date('Y/m').'/'.$file);
                        $n_attach->ext = $upload->getExtension();
                        $n_attach->save();
                    }
                }

                if ($model->progress == Approval::PRO_BACK) {
                    $model->generateStep();
                }

                $outerTransaction->commit();
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (\Exception $e) {
                Yii::error($e->getMessage());
                Yii::$app->session->setFlash('error','数据处理错误，请联系管理员');
                $outerTransaction->rollBack();
            }
        }
        return $this->render('update', [
            'model' => $model,
            'attachs' => $attachs
        ]);
    }

    /**
     * Deletes an existing Approval model.
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
     * Finds the Approval model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Approval the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Approval::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
