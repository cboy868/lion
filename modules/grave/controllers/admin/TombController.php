<?php

namespace app\modules\grave\controllers\admin;

use Yii;
use app\modules\grave\models\Grave;
use app\modules\grave\models\Tomb;
use app\modules\grave\models\search\TombSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use app\modules\grave\models\TombForm;

/**
 * TombController implements the CRUD actions for Tomb model.
 */
class TombController extends BackController
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
     * Lists all Tomb models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TombSearch();
        $params = Yii::$app->request->queryParams;

        $params['TombSearch']['grave_id'] = $params['grave_id'];
        $dataProvider = $searchModel->search($params);

        $grave = Grave::findOne($params['grave_id']);

        if ($grave) {
            $parents = $grave->getParents();
        }




        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'grave' => $grave,
            'parents' => $parents
        ]);
    }

    public function actionList(){
        $searchModel = new TombSearch();

        $params = Yii::$app->request->queryParams;

        if (!$params['grave_id']) {
            return '';
        }

        $params['TombSearch']['grave_id'] = $params['grave_id'];
        $dataProvider = $searchModel->search($params);

        // $this->layout = false;

        return $this->renderAjax('list', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionSelGrave($grave_id)
    {
        $graves = Grave::find()->where(['pid'=>$grave_id])
                               ->andWhere(['<>', 'status', Grave::STATUS_DELETE])
                               ->select(['id', 'name', 'is_leaf'])
                               ->asArray()
                               ->all();

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $status = true;
        $info=null;
        if (!$graves) {
            $status = false;
            $info = '墓区可能存在问题';
        }

        return [
            'status' => $status,
            'info' => $info,
            'data' => $graves
        ];

    }

    /**
     * @name 预定
     */
    public function actionPre($id)
    {
        $tomb = Tomb::findOne($id);
        if ($tomb->pre()) {
            Yii::$app->session->setFlash('success', '墓位预定成功, 请办理购墓手续');
            return $this->json();
        }
        return $this->json(null, '预定失败,请查看墓位状态或联系管理员', 0);
    }

    /**
     * @name 保留
     */
    public function actionRetain($id)
    {
        $tomb = Tomb::findOne($id);
        if ($tomb->retain()) {
            return $this->json();
        }
        
        return $this->json(null, '保留失败,请查看墓位状态或联系管理员', 0);
    }

    public function actionUnPre($id)
    {
        $tomb = Tomb::findOne($id);
        if ($tomb->pre(false)) {
            Yii::$app->session->setFlash('success', '墓位预定成功');
            return $this->json();
        }
        return $this->json(null, '取消预定失败,请查看墓位状态或联系管理员', 0);
    }

    /**
     * @name 保留
     */
    public function actionUnRetain($id)
    {
        $tomb = Tomb::findOne($id);
        if ($tomb->retain(false)) {
            return $this->json();
        }
        
        return $this->json(null, '取消保留失败,请查看墓位状态或联系管理员', 0);
    }

    /**
     * Displays a single Tomb model.
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
     * Creates a new Tomb model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new TombForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->create()) {

            return $this->redirect(['index', 'grave_id' => $model->grave_id]);
            
        } else {

            $grave_id = Yii::$app->request->get('grave_id');

            if ($grave_id) {
                $model->grave_id = $grave_id;
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Tomb model.
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

    /**
     * Deletes an existing Tomb model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionOption($id)
    {
        $tomb= Tomb::findOne($id);
        $options = $tomb->getOptions();

        $desc_tpl = "墓位号:<code>%s</code> 价格:<code>¥%.2f</code> 穴数:<code>%d</code>";
        $desc = sprintf($desc_tpl, $tomb->tomb_no, $tomb->price, $tomb->hole);


        return $this->renderAjax('option', [
                'tomb' => $tomb,
                'options' => $options,
                'desc' => $desc
            ]);
    }

    /**
     * Finds the Tomb model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tomb the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tomb::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
