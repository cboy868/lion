<?php

namespace app\modules\grave\controllers\admin;

use app\modules\grave\models\Customer;
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
use app\core\base\Upload;
use app\core\libs\Fpdf;

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


    public function actionCard($tomb_id)
    {
        $info = Card::info($tomb_id);

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            $info = [];
            foreach ($post as $k => $v) {
                if (in_array($k, ['dead', 'card_dates'])) {

                    foreach ($v as $d) {
                        if (isset($d['flg']) && $d['flg'] ==1) {
                            $info[$k][] = $d['tit'];
                        }
                    }
                }
                if (isset($v['flg']) && $v['flg'] ==1) {
                    $info[$k] = $v['tit'];
                }
            }
            $pdf = new Fpdf('P','mm','A4');
            $pdf->AddPage();
            $pdf->AddGBFont('simkai','楷体_GB2312');

            $result = $this->dealData($info);
            $result = Fpdf::content($result);

            foreach($result as $v){
                $pdf->setXY($v['x'],$v['y']);
                $pdf->SetFont($v['font'],$v['b'],$v['font_size']);
                $pdf->cell(10,10, $v['content']);
            }

            ob_end_clean();
            $pdf->Output();
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('card', ['info'=>$info, 'tomb_id'=>$tomb_id]);
        } else {
            return $this->error();
        }

    }

    private function dealData($info)
    {

        $dead_result = $card_dates = [];
        if (isset($info['dead'])){
            foreach ($info['dead'] as $k => $dd) {
                $dead_result[$k] = [
                    'content' => $dd,
                    'x'=>62,
                    'y'=>19 + $k*13,
                    'b'=>true,
                    'font_size'=>15
                ];
            }
        }

        if (isset($info['card_dates'])){
            foreach ($info['card_dates'] as $k => $dd) {
                $card_dates[$k] = [
                    'content' => $dd,
                    'x'=>62,
                    'y'=>72 + $k*11,
                    'b'=>true,
                    'font_size'=>15
                ];
            }
        }

        $cfg = [
            'card_no'=>['x'=>122, 'y'=>4, 'b'=>true, 'font_size'=>15],
            'tomb_no'=>['x'=>62, 'y'=>45, 'b'=>true, 'font_size'=>15],
            'bury_date'=>['x'=>62, 'y'=>58, 'b'=>true, 'font_size'=>15],
            'customer_name'=>['x'=>62, 'y'=>134, 'b'=>true, 'font_size'=>15],
            'card_date'=>['x'=>62, 'y'=>154, 'b'=>true, 'font_size'=>15],
            'price'=>['x'=>62, 'y'=>174, 'b'=>true, 'font_size'=>15]
        ];

        $result = [];
        foreach ($info as $k=>$v) {
            if (in_array($k, ['dead', 'card_dates'])) continue;
            $result[$k] = [
                'content'=>$v, 'x'=>$cfg[$k]['x'], 'y'=>$cfg[$k]['y'], 'b'=>true, 'font_size'=>15
            ];
        }

        $result = array_merge($result, $dead_result, $card_dates);

        return $result;
    }


    /**
     * @return string
     * @name 墓位列表
     */
//    public function actionIx()
//    {
//        $searchModel = new TombSearch();
//        $params = Yii::$app->request->queryParams;
//
//
//        $grave = null;
//        if (isset($params['grave_id'])) {
//            $params['TombSearch']['grave_id'] = $params['grave_id'];
//            $grave = Grave::findOne($params['grave_id']);
//        }
//
//        $dataProvider = $searchModel->search($params);
//
//        $parents = null;
//        if ($grave) {
//            $parents = $grave->getParents();
//        }
//
//        return $this->render('ix', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//            'grave' => $grave,
//            'parents' => $parents
//        ]);
//    }

    /**
     * @return string
     * @name ajax提取数据
     */
//    public function actionIxlist(){
//        $searchModel = new TombSearch();
//
//        $params = Yii::$app->request->queryParams;
//
////        if (!$params['grave_id']) {
////            return '';
////        }
//
//        $params['TombSearch']['grave_id'] = $params['grave_id'];
//        $dataProvider = $searchModel->search($params);
//
//        return $this->renderAjax('ixlist', [
//            'dataProvider' => $dataProvider,
//            'minCol' => $searchModel->minCol($params)
//        ]);
//    }

    public function actionIndex()
    {
        $searchModel = new TombSearch();
        $params = Yii::$app->request->queryParams;

        if (isset($params['grave_id'])) {
            $params['TombSearch']['grave_id'] = $params['grave_id'];
        }


        if (isset($params['status'])) {
            $params['TombSearch']['status'] = $params['status'];
        }



        $dataProvider = $searchModel->search($params);

        if (isset($params['excel']) && $params['excel']){
            return $this->excel($dataProvider);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    private function excel($dp)
    {

        $columns = [
            'tomb_no',
            [
                'label' => '墓区',
                'value' => function($model) {
                    return $model->grave->name;
                }
            ],
            'hole',
            'price',
            'user.username',
            'customer.name',
            ['label'=>'客户',  'attribute' => 'customer_name',  'value' => 'customer.name' ],//<=====加入这句
            'agent.username',
//                         'agency_id',
            'guide.username',
            // 'sale_time',
            'mnt_by',
            [
                'label' => '销售状态',
                'value' => function($model){
                    if ($model->user_id) {
                        return $model->statusText . '('.$model->user->username.')';
                    }
                    return $model->getStatusText();
                }
            ],
        ];

        $options = [
            'title'=>'墓位',
            'filename'=>'tomb',
            'pageTitle'=>'墓位'
        ];
        \app\core\libs\Export::export($dp, $columns, $options);
    }
    /**
     * Lists all Tomb models.
     * @return mixed
     * @name 列表
     */
    public function actionIndexbak()
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

    /**
     * @return string
     * @name ajax提取数据
     */
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

    /**
     * @param null $client_id
     * @return string
     * @name 查找
     */
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

    /**
     * @return string
     * @name 墓位查找
     */
    public function actionSearchList()
    {
        $searchModel = new TombSearch();

        $params = Yii::$app->request->queryParams;

        $dataProvider = $searchModel->search($params);

        return $this->renderAjax('search-list', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @param $grave_id
     * @return array
     * @name 取墓区数据
     */
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

    /**
     * @param $id
     * @return array
     * @name 取消预定
     */
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
     * @name 添加墓位
     */
    public function actionCreate()
    {

        $model = new TombForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->create()) {

            return $this->redirect(['/grave/admin/tomb/create', 'grave_id'=>$model->grave_id]);
            
        } else {

            $grave_id = Yii::$app->request->get('grave_id');

            if ($grave_id) {
                $model->grave_id = $grave_id;
                $grave = Grave::findOne($grave_id);
                $model->price = $grave->price;

                $data['tombs'] = Tomb::find()->where(['grave_id'=>$grave_id])
                    ->andWhere(['<>', 'status', Tomb::STATUS_DELETE])
                    ->orderBy('row asc,col asc')->all();

                $data['minCol'] = $grave->minCol();
                $data['maxCol'] = $grave->maxCol();
            }
            $data['model'] = $model;

            return $this->render('create', $data);
        }
    }

    /**
     * Updates an existing Tomb model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @name 修改墓位信息
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $thumb = $model->thumb;

        if ($model->load(Yii::$app->request->post()) ) {

            $up = Upload::getInstance($model, 'thumb', 'tomb');

            if ($up) {
                $up->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);
                $up->save();
                $info = $up->getInfo();
                $model->thumb = $info['mid'];
            } else {
                $model->thumb = $thumb;
            }

            $model->save();

            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Tomb model.
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
     * @return array
     * @name 批量删除
     */
    public function actionBatchDel()
    {
        $post = Yii::$app->request->post();

        $ses = Yii::$app->getSession();

        if (empty($post['ids'])) {
            return $this->json(null, '请选择要删除的数据 ', 0);
        }

        $outerTransaction = Yii::$app->db->beginTransaction();

        try{

            Yii::$app->db->createCommand()
                ->update(
                    Tomb::tableName(),
                    ['status'=>Tomb::STATUS_DELETE],
                    ['id'=>$post['ids']]
                )->execute();

            $outerTransaction->commit();

        } catch (\Exception $e){
            $outerTransaction->rollBack();
            return $this->json(null, '删除失败', 0);
        }

        $ses->setFlash('success','数据批量删除成功');
        return $this->json();

    }

    /**
     * @param $id
     * @return string
     * @name 墓位操作列表
     */
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

    public function actionInfo($type=null)
    {
        $post = Yii::$app->request->post();

        if (!$post['grave'] || !$post['row'] || !$post['col']) {
            return $this->json(null, '查找数据不完整', 0);
        }

        $query = Tomb::find()->where(['grave_id'=>$post['grave']])
            ->andWhere(['row'=>$post['row']])
            ->andWhere(['col'=>$post['col']]);

        if ($type) {
            $query->andWhere(['status' => $type]);
        }


        $tomb = $query->one();

        if (!$tomb) {
            return $this->json(null, '墓位不存在', 0);
        }
        $data = [];

        if ($tomb->customer_id) {
            $customer = Customer::findOne($tomb->customer_id);
            $data['customer'] = $customer;
        }

        $data['tomb'] = $tomb;
        $data['tombStatus'] = $tomb->getStatusText();

        return $this->json($data, null, 1);
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
