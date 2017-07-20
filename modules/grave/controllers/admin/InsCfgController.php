<?php

namespace app\modules\grave\controllers\admin;

use Yii;
use app\modules\grave\models\InsCfg;
use app\modules\grave\models\search\InsCfg as InsCfgSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\grave\models\search\InsCfgCase;
use app\modules\grave\models\InsCfgRel;
use app\modules\grave\models\Grave;

use app\core\helpers\ArrayHelper;
/**
 * InsCfgController implements the CRUD actions for InsCfg model.
 */
class InsCfgController extends BackController
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
     * Lists all InsCfg models.
     * @return mixed
     * @name 碑文配置管理
     */
    public function actionIndex()
    {
        $searchModel = new InsCfgSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @name 墓区配置
     */
    public function actionGrave($id)
    {

        $req = Yii::$app->request;

        if ($req->isPost) {
            $grave_id = $req->post('grave_id');
            $cfgs_id = $req->post('cfgs');

            $data = [];
            foreach ($cfgs as $v) {
                $data[] = ['grave_id'=>$grave_id, 'cfg_id'=>$v];
            }
            $rel = new InsCfgRel();

            $rel->load($data, '');
            $rel->save();
        }

        $cfg = InsCfg::findOne($id);
        $graves = Grave::find()->where(['is_leaf'=>1])->orderBy('pid asc')->asArray()->all();

        // p($graves);die;


        $selected = InsCfgRel::find()->where(['cfg_id'=>$id])->asArray()->all();
        $selected = ArrayHelper::getColumn($selected, 'grave_id');

        return $this->render('grave',[
                'selected' => $selected,
                'graves' => $graves,
                'cfg'       => $cfg,
            ]);
    }

    /**
     * @return array
     * @name 墓区碑文模板配置
     */
    public function actionCfgGrave()
    {

        $data = Yii::$app->request->post();
        $action = $data['action'];
        unset($data['action']);

        $flag = true;
        if ($action == 'del') {

            if (isset($data['grave_id']) && $data['grave_id']) {
                $model = InsCfgRel::find()->where($data)->one();
                $flag = $model->delete();
            } else {
                $flag = InsCfgRel::deleteAll('cfg_id = :cfg_id', [':cfg_id' => $data['cfg_id']]);
            }
        } else {

            if (isset($data['grave_id'])) {
                $model = new InsCfgRel;
                $model->load($data, '');
                $flag = $model->save();
            } else {
                $graves = Grave::find()->where(['is_leaf'=>1])->asArray()->all();

                $grave_ids = ArrayHelper::getColumn($graves, 'id');
                $da = [];

                foreach ($grave_ids as $k => $v) {
                    $da = ['grave_id'=>$v, 'cfg_id'=>$data['cfg_id']];
                    $model = new InsCfgRel;
                    $model->load($da, '');
                    $model->save();
                    unset($model);
                }
            }
        }

        if ($flag) {
            return $this->json();
        } else {
            return $this->json(null, '操作失败，请重试或联系管理员', 0);
        }

    }





    // public function allGrave(){
    //     $cfg_id = $_POST['cfg_id'];
    
    //     if ($_POST['action'] == 'add') {
    //         $grave_ids = M('grave')->field('id')->select();
    //         $grave_ids = extractField($grave_ids, 'id');
                
    //         $data = array();
    //         foreach ($grave_ids as $v) {
    //         $data[] = array('grave_id'=>$v, 'cfg_id'=>$cfg_id);
    //         }
    //         if(M('ins_cfg_grave_rel')->addAll($data)){
    //         $this->ajaxReturn(null, null, 1);
    //         }
    //     } else {
    //         if(M('ins_cfg_grave_rel')->where(array('cfg_id'=>$cfg_id))->delete()){
    //             $this->ajaxReturn(null, null, 1);
    //         }
    //     }
    //     $this->ajaxReturn(null, '操作失败', 0);
    // }












    /**
     * Displays a single InsCfg model.
     * @param integer $id
     * @return mixed
     */
//    public function actionView($id)
//    {
//
//        $condition = array('cfg_id' => $id,'status' => 1);
//        $all = InsCfgCase::find()->where(['cfg_id'=>$id, 'status'=>1])->asArray()->all();
//
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//            'all' => $all,
//        ]);
//    }

    /**
     * Creates a new InsCfg model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 添加
     */
    public function actionCreate()
    {
        $model = new InsCfg();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing InsCfg model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @name 修改
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing InsCfg model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the InsCfg model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InsCfg the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InsCfg::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
