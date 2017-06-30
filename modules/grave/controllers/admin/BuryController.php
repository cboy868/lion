<?php

namespace app\modules\grave\controllers\admin;

use app\modules\grave\models\Card;
use app\modules\grave\models\OrderRel;
use Yii;
use app\modules\grave\models\Bury;
use app\modules\grave\models\search\BurySearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\grave\models\Tomb;

/**
 * BuryController implements the CRUD actions for Bury model.
 */
class BuryController extends BackController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'confirm' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Bury models.
     * @return mixed
     * @name 安葬记录
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;
        $params['BurySearch']['status'] = Bury::STATUS_OK;
        $searchModel = new BurySearch();
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string
     * @name 预葬记录
     */
    public function actionPre()
    {
        $searchModel = new BurySearch();

        $params = Yii::$app->request->queryParams;

        $params['BurySearch']['status'] = Bury::STATUS_NORMAL;

        $dataProvider = $searchModel->search($params);

        return $this->render('pre', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Bury model.
     * @param integer $id
     * @return mixed
     *
     */
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }

    /**
     * Creates a new Bury model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new Bury();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * Updates an existing Bury model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * @name 确认安葬
     */
    public function confirmBury()
    {
        $post = Yii::$app->request->post();

        $bury = Bury::findOne($post['id']);
        $bury->status = Bury::STATUS_OK;

        $tomb = Tomb::findOne($bury['tomb_id']);
        $tomb->afterBuryConfirm();


        if ($bury->save()) {
            return $this->json();
        }

        return $this->json(null, '确认安葬出错，请联系管理员', 0);
    }


    public function actionConfirm($id)//这个方法不应该是这样，应该是弹出窗口，选择完安葬员及礼仪再ok，暂时先这样吧
    {
        $bury = Bury::findOne($id);
        $bury->status = Bury::STATUS_OK;
        if ($bury->save()) {


            $params = Yii::$app->getModule('grave')->params['tomb_card'];

            if ($params['start'] == 'bury') {
                $order_rel = OrderRel::find()->where(['status'=>OrderRel::STATUS_NORMAL])
                    ->andWhere(['tid'=>$bury->tomb_id])
                    ->andWhere(['goods_id'=>$params['goods_id']])
                    ->one();
                $order_rel_id = isset($order_rel->id) ? $order_rel->id : 0;

                Card::initCard($bury->tomb_id, $order_rel_id);
            }

            $tomb = Tomb::findOne($bury['tomb_id']);
            $tomb->afterBuryConfirm();

            Yii::$app->session->setFlash('success', '确认安葬成功');
//            return $this->json();
        }


        return $this->redirect('pre');

        //return $this->render('confirm');
    }
    /**
     * Deletes an existing Bury model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Bury::STATUS_DELETE;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Bury model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Bury the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bury::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
