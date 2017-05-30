<?php

namespace app\modules\grave\controllers\admin;

use Yii;
use app\modules\grave\models\InsCfgCase;
use app\modules\grave\models\search\InsCfgCase as InsCfgCaseSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InsCfgCaseController implements the CRUD actions for InsCfgCase model.
 */
class InsCfgCaseController extends BackController
{

    public static $num = 4;


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
     * Lists all InsCfgCase models.
     * @return mixed
     * @name 碑文配置实例列表
     */
    public function actionIndex()
    {

        $params = Yii::$app->request->queryParams;
        $params['InsCfgCase']['cfg_id'] = isset(Yii::$app->request->queryParams['cfg_id']) ? Yii::$app->request->queryParams['cfg_id'] : '';
        $searchModel = new InsCfgCaseSearch();
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InsCfgCase model.
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
     * Creates a new InsCfgCase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 添加
     */
    public function actionCreate($cfg_id)
    {
        $model = new InsCfgCase();
        $model->cfg_id = $cfg_id;

        if ($model->load(Yii::$app->request->post())) {

            if (empty($model->num)) {
                for ($i=1; $i <= self::$num; $i++) { 
                    $m = clone $model;
                    $m->num = $i;
                    $m->save();
                    unset($m);
                }
            } else {
                $model->save();
            }


            return $this->redirect(['index', 'cfg_id'=>$cfg_id]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing InsCfgCase model.
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
     * Deletes an existing InsCfgCase model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $cfg_id = $model->cfg_id;
        $model->delete();

        return $this->redirect(['index', 'cfg_id'=>$cfg_id]);
    }

    /**
     * Finds the InsCfgCase model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InsCfgCase the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InsCfgCase::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
