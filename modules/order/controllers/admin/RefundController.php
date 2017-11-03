<?php

namespace app\modules\order\controllers\admin;

use app\core\helpers\ArrayHelper;
use app\modules\analysis\models\SettlementRel;
use app\modules\order\models\OrderRel;
use Yii;
use app\modules\order\models\Refund;
use app\modules\order\models\RefundSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RefundController implements the CRUD actions for Refund model.
 */
class RefundController extends BackController
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
     * Lists all Refund models.
     * @return mixed
     * @name 退款列表
     */
    public function actionIndex()
    {
        $searchModel = new RefundSearch();
        $params = Yii::$app->request->queryParams;
        $params['RefundSearch']['status'] = Refund::STATUS_NORMAL;
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Refund model.
     * @param integer $id
     * @return mixed
     * @name 退款详细
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        SettlementRel::refund($model);




        $intro = json_decode($model->intro, true);
        $rel_ids = ArrayHelper::getColumn($intro, 'rel_id');

        $rel_tomb = OrderRel::find()->where(['type'=>9,'id'=>$rel_ids])->one();

        if ($rel_tomb) {//退墓操作

        }

        p($rel_tomb);die;

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Refund model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 退款申请
     */
    public function actionCreate()
    {
        $model = new Refund();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Refund model.
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
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @name 退款审核
     */
    public function actionVerify($id)
    {
        $model = $this->findModel($id);
        $v = Yii::$app->request->get('v');

        if ($v == Refund::PRO_PASS) {  
            $flag = $model->verify();
        } else if ($v == Refund::PRO_NOPASS) {
            $flag = $model->noVerify();
        } else if ($v == Refund::PRO_OK) {
            $flag = $model->feeOk();
        }
        if ($flag) {
            Yii::$app->session->setFlash('success', '操作成功');
        }

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Refund model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->del();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Refund model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Refund the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Refund::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
