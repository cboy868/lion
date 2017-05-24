<?php

namespace app\modules\wechat\controllers\admin;

use Yii;
use app\modules\wechat\models\Wechat;
use app\modules\wechat\models\WechatSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\core\web\BackController;


/**
 * AccountController implements the CRUD actions for Wechat model.
 */
class AccountController extends BackController
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
     * Lists all Wechat models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WechatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @name 选择操作的公众号
     */
    public function actionSwitch($id)
    {
        $model = $this->findModel($id);
        if (!$model) {
            return $this->error('不存在此公众号,请重新选择');
        }
        $session = \Yii::$app->session;

        $session['wechat.id'] = $model->id;
        $session['wechat.name'] = $model->name;
        $session['wechat.appid'] = $model->appid;
        $session['wechat.appsecret'] = $model->appsecret;
        $session['wechat.token'] = $model->token;

        return $this->redirect(['/wechat/admin/default/index']);
    }

    /**
     * Displays a single Wechat model.
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
     * Creates a new Wechat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Wechat();

        if ($model->load(Yii::$app->request->post()) ) {
            $model->generateAeskey();
            $model->generateToken();

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Wechat model.
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
     * Deletes an existing Wechat model.
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
     * Finds the Wechat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Wechat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Wechat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
