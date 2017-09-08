<?php

namespace app\modules\grave\controllers\admin;

use Yii;
use app\modules\grave\models\Dead;
use app\modules\grave\models\search\DeadSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DeadController implements the CRUD actions for Dead model.
 */
class DeadController extends BackController
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
     * Lists all Dead models.
     * @return mixed
     * @name 使用人记录
     */
    public function actionIndex()
    {
        $searchModel = new DeadSearch();
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
                'label' => '墓位号',
                'value' => function($model){
                    return $model->tomb->tomb_no;
                },
                'format'=>'raw'
            ],
            'dead_name',
            [
                'label' => '账号',
                'value' => function($model){
                    return $model->user->username;
                }
            ],
            [
                'label' => '纪念馆名',
                'value' => function($model){
                    if (!isset($model->memorial)) {return '';}
                    return $model->memorial->title;
                },
                'format' => 'raw'
            ],
            // 'second_name',
             'dead_title',
            // 'serial',
            // 'gender',
             'birth_place',
            'birth',
            'fete',
            // 'is_alive',
            // 'is_adult',
            // 'age',
            // 'follow_id',
            // 'desc:ntext',
            // 'is_ins',
            // 'bone_type',
            // 'bone_box',
            [
                'label' => '预葬日期',
                'value' => function($model){
                    return date('Y-m-d', strtotime($model->pre_bury));
                }
            ],
            'bury',
        ];

        $options = [
            'title'=>'使用人',
            'filename'=>'deads',
            'pageTitle'=>'使用人'
        ];
        \app\core\libs\Export::export($dp, $columns, $options);
    }

    /**
     * Displays a single Dead model.
     * @param integer $id
     * @return mixed
     * @name 使用人明细
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Dead model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 添加
     */
    public function actionCreate()
    {
        $model = new Dead();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Dead model.
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
     * Deletes an existing Dead model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Dead::STATUS_NORMAL;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Dead model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dead the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dead::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
