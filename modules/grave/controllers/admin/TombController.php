<?php

namespace app\modules\grave\controllers\admin;

use Yii;
use app\modules\grave\models\Grave;
use app\modules\grave\models\Tomb;
use app\modules\grave\models\search\TombSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\grave\models\Card;
use app\modules\shop\models\Goods;
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

    public function actions()
    {
        return [
            'pl-upload' => [
                'class' => 'app\core\web\PluploadAction',
            ],
        ];
    }

    public function saveAttach($info)
    {
        $tomb = Tomb::findOne($info['res_id']);

        if (!$tomb) {
            return null;
        }

        return $tomb->saveAttach($info);
    }

    public function actionIx()
    {
        $searchModel = new TombSearch();
        $params = Yii::$app->request->queryParams;


        $grave = null;
        if (isset($params['grave_id'])) {
            $params['TombSearch']['grave_id'] = $params['grave_id'];
            $grave = Grave::findOne($params['grave_id']);
        }

        $dataProvider = $searchModel->search($params);

        $parents = null;
        if ($grave) {
            $parents = $grave->getParents();
        }

        return $this->render('ix', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'grave' => $grave,
            'parents' => $parents
        ]);
    }

    public function actionIxlist(){
        $searchModel = new TombSearch();

        $params = Yii::$app->request->queryParams;

        if (!$params['grave_id']) {
            return '';
        }

        $params['TombSearch']['grave_id'] = $params['grave_id'];
        $dataProvider = $searchModel->search($params);

        return $this->renderAjax('ixlist', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Lists all Tomb models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TombSearch();
        $params = Yii::$app->request->queryParams;


        $grave = null;
        if (isset($params['grave_id'])) {
            $params['TombSearch']['grave_id'] = $params['grave_id'];
            $grave = Grave::findOne($params['grave_id']);
        }

        $dataProvider = $searchModel->search($params);

        $parents = null;
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

        return $this->renderAjax('list', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionSearch($client_id = null)
    {

        $tombs = [];
        if ($client_id) {
            $customer = \app\modules\grave\models\Customer::find()->where(['client_id'=>$client_id])->one();

            if ($customer) {
                $tombs = Tomb::find()->where(['customer_id'=>$customer->id])
                                ->andWhere(['<>', 'status', Tomb::STATUS_DELETE])
                                ->all();
            }
        }


        $searchModel = new TombSearch();

        return $this->renderAjax('search', ['model'=>$searchModel, 'tombs'=>$tombs]);
    }

    public function actionSearchList()
    {
        $searchModel = new TombSearch();

        $params = Yii::$app->request->queryParams;

        $dataProvider = $searchModel->search($params);

        return $this->renderAjax('search-list', [
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
    public function actionPre($id, $client_id=null)
    {
        $tomb = Tomb::findOne($id);
        if ($tomb->pre(true, $client_id)) {
//            Yii::$app->session->setFlash('success', '墓位预定成功, 请办理购墓手续');
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
                $grave = Grave::findOne($grave_id);
                $model->price = $grave->price;
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
     * @name 续费
     */
    public function actionRenew($id)
    {
        $model = $this->findModel($id);

        $config = Yii::$app->params['goods'];
        $gid = $config['id']['renew'];
        $fee = $config['fee']['renew'];

        $ginfo = Goods::createVirtual($gid['id'], $gid['name']);

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            $extra = [
                'price' => $post['num'] * $fee * $model->price,
                'num'   => $post['num'],
                'tid'   => $model->id,
                'note'  => $post['des']
            ];
            $info = $ginfo->order($model->user_id, $extra);
            if ($info['order']) {
                return $this->redirect(['/order/admin/default/view', 'id'=>$info['order']->id]);
            }
        }
        
        $ginfo = \app\modules\shop\models\Goods::findOne($gid);
        $ginfo->original_price = $ginfo->price = $model->price * $fee;

        return $this->render('renew', ['model'=>$model, 'ginfo'=>$ginfo]);
    }

    /**
     * @name 改墓
     */
    public function actionRenovate($id)
    {
        $model = $this->findModel($id);

        $gid = Yii::$app->params['goods']['id']['renovate'];
        $taskCate = \app\modules\task\models\Info::find()->all();

        $goods = Goods::createVirtual($gid['id'], $gid['name']);
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            
            $extra = [
                'tid' => $id,
                'use_time' => $post['sp']['use_time'],
                'price' => $post['sp']['price'],
                'note' => $post['sp']['intro']
            ];
            $info = $goods->order($model->user_id, $extra);
            if ($info['order']) {
                return $this->redirect(['/order/admin/default/view', 'id'=>$info['order']->id]);
            }
        }

        return $this->render('renovate', ['model'=>$model]);
    }

    /**
     * @name 碑文修金箔
     */
    public function actionRepair($id)
    {
        $model = $this->findModel($id);

        if (!$model->ins) {
            return $this->error('此墓位不存在碑文，请先完善或走特殊业务');
        }

        $config = Yii::$app->params['goods'];


        $fee = $this->module->params['ins']['fee']['repair'];
        $paint = $this->module->params['ins']['paint'];
        $gid = $config['id']['repair'];
        $goods = Goods::createVirtual($gid['id'], $gid['name']);

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            $extra = [
                'price' => $post['num'] * $fee[$post['paint']],
                'num'   => $post['num'],
                'tid'   => $model->id,
                'note'  => $post['des']
            ];
            $info = $goods->order($model->user_id, $extra);
            if ($info['order']) {
                return $this->redirect(['/order/admin/default/view', 'id'=>$info['order']->id]);
            }
        }

        return $this->render('repair',['model'=>$model, 'fee'=>$fee,'paint'=>$paint]);
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
