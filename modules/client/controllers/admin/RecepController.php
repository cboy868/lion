<?php

namespace app\modules\client\controllers\admin;

use Yii;
use app\modules\client\models\Client;
use app\modules\client\models\Deal;

use app\modules\client\models\Reception;
use app\modules\client\models\ReceptionSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RecepController implements the CRUD actions for Reception model.
 */
class RecepController extends BackController
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
     * Lists all Reception models.
     * @return mixed
     * @name 客户联系记录
     */
    public function actionIndex($id)
    {
        $client = Client::findOne($id);
        $recep = new Reception();
        
        if ($recep->load(Yii::$app->request->post()) && $recep->save()) {
            return $this->redirect(['index', 'id' => $id]);
        } 



        //查找未挂在接待记录中的deal
        $deals = Deal::find()->where(['client_id'=>$id, 'recep_id'=>0])
                             ->andWhere(['<>', 'status', Deal::STATUS_DEL])
                             ->all();

        $recep->loadDefaultValues();
        $recep->client_id = $client->id;
        $recep->guide_id = Yii::$app->user->id;
        return $this->render('index', [
                'client' => $client,
                'model' => $recep,
                'deals' => $deals
        ]);
    }

    /**
     * Displays a single Reception model.
     * @param integer $id
     * @return mixed
     */
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }

    /**
     * Creates a new Reception model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 添加新联系记录
     */
    public function actionCreate()
    {
        $model = new Reception();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Reception model.
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
     * @return array
     * @name 本次接待成交
     */
    public function actionDeal()
    {
        $post = Yii::$app->request->post();

        $recep = $this->findModel($post['recep_id']);
        $recep->is_success = 1;
        $recep->save();
        $deal = Deal::findOne($post['deal_id']);
        $deal->recep_id = $post['recep_id'];


        if ($deal->save()) {
            return $this->json();
        }
        return $this->json(null, '出错', 0);
    }

    /**
     * Deletes an existing Reception model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

    /**
     * Finds the Reception model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Reception the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reception::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
