<?php

namespace app\modules\shop\controllers\admin;

use app\modules\shop\models\Sku;
use Yii;
use app\modules\shop\models\InventoryStorage;
use app\modules\shop\models\search\InventoryStorage as InventoryStorageSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\shop\models\InventoryStorageRel;
use app\modules\shop\models\search\InventoryStorageRel as InventoryStorageRelSearch;
/**
 * InventoryStorageController implements the CRUD actions for InventoryStorage model.
 */
class InventoryStorageController extends BackController
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
     * Lists all InventoryStorage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InventoryStorageSearch();
        $params = Yii::$app->request->queryParams;
        $params['InventoryStorage']['status'] = InventoryStorage::STATUS_NORMAL;
        $dataProvider = $searchModel->search($params);

        $data = [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];

        $id = Yii::$app->request->get('id');
        if ($id) {
            $params['InventoryStorageRel']['storage_id'] = $id;
            $relSearchModel = new InventoryStorageRelSearch();
            $relDataProvider = $relSearchModel->search($params);
            $data['relDataProvider'] = $relDataProvider;
        }

        return $this->render('index', $data);
    }

    /**
     * @name 同步
     */
    public function actionSync($storage)
    {
        $skus = Sku::find()->where(['NOT', ['num' => null]])->asArray()->all();

        $st = InventoryStorage::findOne($storage);

        Yii::$app->db->createCommand()
            ->delete(InventoryStorageRel::tableName(),[
                'storage_id' => $storage,
            ])
            ->execute();

        foreach ($skus as $v) {
            $st->add($v['goods_id'], $v['id'], $v['num']);
        }

        return $this->redirect(['index', 'id'=>$storage]);

    }

    /**
     * Displays a single InventoryStorage model.
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
     * Creates a new InventoryStorage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new InventoryStorage();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing InventoryStorage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
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
     * Deletes an existing InventoryStorage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {

        $post = Yii::$app->request->post();
        $move_to_id = $post['storage'];
        $id = $post['id'];
        $current_id = $post['current_id'];


        if (!$id) {
            Yii::$app->session->setFlash('error', '删除失败，请刷新页面后再执行此操作');
            return $this->redirect(['index', 'id'=>$current_id]);
        }

        if ($id == $current_id) {
            $current_id = null;
        }

        //查看待删除的库中是否有库存
        $rels = InventoryStorageRel::find()->where(['storage_id'=>$id])->one();

        if ($rels) {
            if (!$move_to_id) {
                Yii::$app->session->setFlash('error', '删除失败，库中尚有库存，请先把现有库存转移到其它库');
                return $this->redirect(['index', 'id'=>$current_id]);
            }

            Yii::$app->db->createCommand()
                ->update(
                    InventoryStorageRel::tableName(),
                    ['storage_id' => $move_to_id],
                    ['storage_id'=>$id])
                ->execute();

        }

        $model = $this->findModel($id);
        $model->status = InventoryStorage::STATUS_DEL;
        $model->save();

        Yii::$app->session->setFlash('success', '删除成功');
        return $this->redirect(['index', 'id'=>$current_id]);
    }

    /**
     * Finds the InventoryStorage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InventoryStorage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InventoryStorage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
