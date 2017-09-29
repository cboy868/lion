<?php

namespace app\modules\shop\controllers\admin;

use Yii;
use app\modules\shop\models\Goods;
use app\modules\shop\models\Sku;
use app\modules\shop\models\InventoryPurchase;
use app\modules\shop\models\InventoryPurchaseRel;
use app\modules\shop\models\search\InventoryPurchaseRel as InventoryPurchaseRelSearch;
use app\modules\shop\models\search\InventoryPurchase as InventoryPurchaseSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
/**
 * InventoryPurchaseController implements the CRUD actions for InventoryPurchase model.
 */
class InventoryPurchaseController extends BackController
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
     * Lists all InventoryPurchase models.
     * @return mixed
     * @name 进货入库
     */
    public function actionIndex()
    {

        $id = Yii::$app->request->get('id');

        //record
        $searchModel = new InventoryPurchaseSearch();
        $params = Yii::$app->request->queryParams;
        $params['InventoryPurchase']['status'] = InventoryPurchase::STATUS_NORMAL;
        $dataProvider = $searchModel->search($params);

        if (!$id) {
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            //record rel
            $rel_searchModel = new InventoryPurchaseRelSearch();
            $rel_params = Yii::$app->request->queryParams;
            $rel_params['InventoryPurchaseRel']['record_id'] = $id;
            $rel_params['InventoryPurchaseRel']["status"] = InventoryPurchaseRel::STATUS_NORMAL;

            $rel_dataProvider = $rel_searchModel->search($rel_params);

            $record = $this->findModel($id);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'rel_dataProvider' => $rel_dataProvider,
                'rel_searchModel' => $rel_searchModel,
                'record' => $record
            ]);
        }

        
    }

    /**
     * @name 退货记录
     */
    public function actionRefunds()
    {
        $searchModel = new InventoryPurchaseRelSearch();
        $params = Yii::$app->request->queryParams;
        $params['InventoryPurchaseRel']["status"] = InventoryPurchaseRel::STATUS_REFUND;

        $dataProvider = $searchModel->search($params);


        return $this->render('refunds', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @name 退货
     */
    public function actionRefund($id)
    {
        $outerTransaction = Yii::$app->db->beginTransaction();

        try {
            $model=  $this->findModel($id);
            $model->status = InventoryPurchase::STATUS_REFUND;
            $model->save();

            foreach ($model->rels as $k => $rel) {
                $rel->status = InventoryPurchaseRel::STATUS_REFUND;
                $rel->save();
                Sku::updateNum($rel->sku_id, -$rel->num);
            }
            $outerTransaction->commit();
        } catch (\Exception $e) {
            $outerTransaction->rollBack();
        }

        return $this->redirect('index');
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @name 退货关联
     */
    public function actionRelRefund($id)
    {

        $model = InventoryPurchaseRel::findOne($id);

        $model->status = InventoryPurchaseRel::STATUS_REFUND;
        $model->save();
        Sku::updateNum($model->sku_id, -$model->num);

        return $this->redirect(['index', 'id'=>$model->record_id]);
    }

    /**
     * Displays a single InventoryPurchase model.
     * @param integer $id
     * @return mixed
     * @name 进货详细信息
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            $data = $post['in'];

            if (!$data) {
                return ;
            }

            $outerTransaction = Yii::$app->db->beginTransaction();

            try {
                foreach ($data as $k => $v) {
                    $rel = new InventoryPurchaseRel;
                    $data = [
                        'record_id' => $id,
                        'supplier_id' => $model->supplier->id,
                        'goods_id'  => $v['goods_id'],
                        'sku_id' => $k,
                        'unit_price' => $v['unit_price'],
                        'unit' => $v['unit'],
                        'num' => $v['num'],
                        'total' => $v['total'],
                        'retail' => $v['retail'],
                        'op_id' => Yii::$app->user->id,
                        'op_name'=> Yii::$app->user->identity->username,
                        'note' => $v['note']
                    ];

                    $rel->load($data, '');
                    $rel->save();
                    Sku::updateNum($k, $v['num']);

                    unset($rel);
                }

                $outerTransaction->commit();
            } catch (\Exception $e) {
                $outerTransaction->rollBack();
                return $this->json(null, $e->getMessage(), 0);
            }

            return $this->json();
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    // public function actionRels($id)
    // {
    //     $query = InventoryPurchaseRel::find()->where(['record_id'=>$id, 'status'=>InventoryPurchaseRel::STATUS_NORMAL]);

    //     $count = $query->count();
    //     $pagination = new Pagination(['totalCount' => $count, 'pageSize'=>10]);
    //     $list = $query->offset($pagination->offset)
    //                   ->limit($pagination->limit)
    //                   ->all();

    //     return $this->renderAjax('rels', [
    //             'list' => $list,
    //             'pagination' => $pagination
    //         ]);
    // }

    /**
     * Creates a new InventoryPurchase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 新增进货记录
     */
    public function actionCreate()
    {
        $model = new InventoryPurchase();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $model->op_id = Yii::$app->user->id;
            $model->op_name = Yii::$app->user->identity->username;
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing InventoryPurchase model.
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
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing InventoryPurchase model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除
     */
    public function actionDelete($id)
    {

        $model = $this->findModel($id);
        $model->status = InventoryPurchase::STATUS_DEL;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * @param null $sp
     * @param null $bm
     * @param null $name
     * @return string
     * @name ajax取进货列表
     */
    public function actionGlist($sp=null, $bm=null, $name=null)
    {

        $sp = trim($sp);
        $bm = trim($bm);
        $name = trim($name);

        if (empty($sp) && empty($bm) && empty($name)) {
            return '';
        }

        $get = Yii::$app->request->queryParams;

        $query = Goods::find()->andFilterWhere(['like','pinyin', $sp])
                              ->andFilterWhere(['like','serial',$bm])
                              ->andFilterWhere(['like','name', $name]);

        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize'=>10]);

        $list = $query->offset($pagination->offset)
                      ->limit($pagination->limit)
                      ->all();

        return $this->renderAjax('glist', [
                'list' => $list,
                'pagination' => $pagination
            ]);
    }

    /**
     * Finds the InventoryPurchase model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InventoryPurchase the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InventoryPurchase::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
