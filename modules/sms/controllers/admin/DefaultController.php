<?php

namespace app\modules\sms\controllers\admin;

use Yii;
use app\modules\sms\models\Send;
use app\modules\sms\models\SendSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\user\models\User;
use app\core\helpers\ArrayHelper;

/**
 * DefaultController implements the CRUD actions for Send model.
 */
class DefaultController extends BackController
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
     * Lists all Send models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SendSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = new Send();


        if ($model->load(Yii::$app->request->post())) {

            if (!$model->time) {
                $model->time = date('Y-m-d H:i:s');//马上
            }

            $users = self::parseUsers($model);


            foreach ($users as $k => $v) {
                if (!$v) {
                    continue;
                }
                $m = new Send();
                $m->mobile = $v;
                $m->time = $model->time;
                $m->msg = $model->msg;
                $m->save();
            }


            return $this->redirect(['index']);

        }


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);

    }

    /**
     * Displays a single Send model.
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
     * Creates a new Send model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new Send();
//
//        if ($model->load(Yii::$app->request->post())) {
//
//        	if (!$model->time) {
//        		$model->time = date('Y-m-d H:i:s');//马上
//        	}
//
//        	$users = self::parseUsers($model);
//
//
//        	foreach ($users as $k => $v) {
//        		if (!$v) {
//        			continue;
//        		}
//        		$m = new Send();
//        		$m->mobile = $v;
//        		$m->time = $model->time;
//        		$m->msg = $model->msg;
//        		$m->save();
//        	}
//
//
//        	return $this->redirect(['index']);
//
//        } else {
//
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
//    }

    public function parseUsers($model)
    {

    	if ($model->type == 'other') {
    		return array_filter(explode(',', $model->mobile));
    	} else if ($model->type == 'staff') {
    		$users = \app\modules\user\models\User::staffs();
    		return array_filter(ArrayHelper::getColumn($users, 'mobile'));
    	} else if ($model->type == 'customer') {
    		$users = \app\modules\user\models\User::noStaffs();
    		return array_filter(ArrayHelper::getColumn($users, 'mobile'));
    	}
    }

    /**
     * Updates an existing Send model.
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
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Send model.
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
     * Finds the Send model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Send the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Send::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
