<?php

namespace app\modules\grave\controllers\admin;

use Yii;
use app\modules\grave\models\Ins;
use app\modules\grave\models\search\InsSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InsController implements the CRUD actions for Ins model.
 */
class InsController extends BackController
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
     * Lists all Ins models.
     * @return mixed
     * @name 碑文列表
     */
    public function actionIndex()
    {
        $searchModel = new InsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (isset(Yii::$app->request->queryParams['excel']) && Yii::$app->request->queryParams['excel']){
            return $this->excel($dataProvider);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    private function excel($dp)
    {

        $columns = [
            [
                'label' =>'墓位号',
                'value' => function($model) {
                    return $model->tomb->tomb_no;
                },
                'format' => 'raw'
            ],
            [
                'label' => '碑',
                'value' => function($model){
                    return $model->goods->name;
                }
            ],
            'guide.username',
            'user.username',
            [
                'label' => '碑型',
                'value' => function($model){
                    return $model->shape == 'v' ? '竖' : '横';
                }
            ],
            [
                'label' => '是否繁体',
                'value' => function($model){
                    $ar = [0=>'否', 1=>'是'];
                    return $ar[$model->is_tc];
                }
            ],
            'small_num',
            'big_num',
            [
                'label' => '已确认',
                'value' => function($model){
                    return $model->is_confirm ? '是' : '<font color="red">否</font>';
                },
                'format' => 'raw'
            ],
            'confirm_date',
            'confirm.username',
            'pre_finish',
             'finish_at',
            'paintTxt',
        ];

        $options = [
            'title'=>'碑文',
            'filename'=>'ins',
            'pageTitle'=>'碑文'
        ];
        \app\core\libs\Export::export($dp, $columns, $options);
    }

    /**
     * Displays a single Ins model.
     * @param integer $id
     * @return mixed
     * @name 碑文详情
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Ins model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new Ins();
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
     * Updates an existing Ins model.
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
     * Deletes an existing Ins model.
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
     * Finds the Ins model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ins the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ins::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
