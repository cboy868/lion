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

    public function actionRel($id)
    {
        $model = $this->findModel($id);

        $searchModel = new BagSearch();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            try {
                $outerTransaction = Yii::$app->db->beginTransaction();
                if ($post['sku']) {
                    $sku_ids = array_keys($post['sku']);
                    $sku = Sku::find()->where(['id'=>$sku_ids])->indexBy('id')->all();

                    $model->load($post);
                    $model->save();

                    foreach ($post['sku'] as $k => $v) {
                        $rel = new BagRel;
                        $rel->sku_id = $k;
                        $rel->num = $v;
                        $rel->unit_price = $sku[$k]->price;
                        $rel->price = $sku[$k]->price;
                        $rel->bag_id = $model->id;
                        $rel->save();
                        unset($rel);
                    }
                }
                $outerTransaction->commit();

                return $this->redirect(['view', 'id' => $model->id]);
            } catch (\Exception $e) {
                $outerTransaction->rollBack();
            }
        }

        return $this->render('rel',[
            'model' => $model,
            'searchModel' => $searchModel
        ]);

    }

    public function actionSearchGoods()
    {
        $params = Yii::$app->request->queryParams;

        $goods = Goods::find()->where($params)->all();


        return $this->renderAjax('search-goods', [
                'goods' => $goods
        ]);
    }

    /**
     * Updates an existing Bag model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
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
