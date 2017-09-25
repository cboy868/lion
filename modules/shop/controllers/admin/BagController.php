<?php

namespace app\modules\shop\controllers\admin;

use Yii;
use app\modules\shop\models\Bag;
use app\modules\shop\models\BagRel;
use app\modules\shop\models\Sku;
use app\modules\shop\models\search\BagSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\core\models\AttachmentRel;
use app\core\models\Attachment;
use app\modules\shop\models\Goods;
use app\core\base\Pagination;
/**
 * BagController implements the CRUD actions for Bag model.
 */
class BagController extends BackController
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
            'web-upload' => [
                'class' => 'app\core\web\WebuploadAction',
            ],
            'ue-upload' => [
                'class' => 'app\core\widgets\Ueditor\UploadAction',
            ]
        ];
    }

    /**
     * Lists all Bag models.
     * @return mixed
     * @name 打包品列表
     */
    public function actionIndex()
    {
        $searchModel = new BagSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Bag model.
     * @param integer $id
     * @return mixed
     * @name 打包品明细
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Bag model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 创建打包品
     */
    public function actionCreate()
    {
        $model = new Bag();
        $rel   = new BagRel();

        $info = Yii::$app->request->post();

        if ($model->load($info)) {

            $model->op_id = Yii::$app->user->id;


            if (isset($info['mid']) && count($info['mid']) > 0) {
                $mids = $info['mid'];
                $titles = $info['title'];

                foreach ($mids as $k => $v) {
                    AttachmentRel::updateResId('goods_bag', $v, $model->id, $titles[$k]);
                }
                $model->thumb = array_shift($mids);
            }

            $model->save();
            return $this->redirect(['rel', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'rel'   => $rel
            ]);
        }
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @name 打包品关联商品
     */
    public function actionRel($id)
    {
        $model = $this->findModel($id);

        $searchModel = new BagSearch();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            $connection = Yii::$app->db;

            try {
                $outerTransaction = Yii::$app->db->beginTransaction();
                if ($post['sku']) {
                    $sku_ids = array_keys($post['sku']);
                    $sku = Sku::find()->where(['id'=>$sku_ids])->indexBy('id')->all();

                    $model->load($post);
                    $model->save();

                    $connection->createCommand()->delete(BagRel::tableName(), ['bag_id'=>$model->id])->execute();
                    foreach ($post['sku'] as $k => $v) {
                        $rel = new BagRel;
                        $rel->sku_id = $k;
                        $rel->num = $v;
                        $rel->unit_price = $sku[$k]->price;
                        $rel->price = $sku[$k]->price;
                        $rel->goods_id = $sku[$k]->goods_id;
                        $rel->bag_id = $model->id;
                        $rel->save();
                        unset($rel);
                    }
                }
                $outerTransaction->commit();

                return $this->redirect(['view', 'id' => $model->id]);
            } catch (\Exception $e) {
                p($e->getMessage());die;
                Yii::error($e->getMessage(),__METHOD__);
                $outerTransaction->rollBack();
            }
        }

        if (!$model->rate == 0) {
            $model->rate = 100;
        }

        return $this->render('rel',[
            'model' => $model,
            'searchModel' => $searchModel
        ]);

    }

    /**
     * @return string
     * @name ajax 调取商品
     */
    public function actionSearchGoods()
    {
        $params = Yii::$app->request->queryParams;

        $query = Goods::find();
        if (isset($params['category_id']) && !empty($params['category_id'])) {
            $query->where(['category_id'=>$params['category_id']]);
        }

        if (isset($params['name']) && !empty($params['name'])) {
            $query->andWhere(['like', 'name', $params['name']]);
        }

        $count = $query->count();
        $pagination = new Pagination(['totalCount'=>$count]);

        $goods = $query->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->renderAjax('search-goods', [
                'goods' => $goods,
                'pagination' => $pagination
        ]);
    }

    /**
     * Updates an existing Bag model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @name 修改
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['rel', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Bag model.
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
     * Finds the Bag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Bag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bag::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
