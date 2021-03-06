<?php

namespace app\modules\grave\controllers\admin;

use app\core\helpers\ArrayHelper;
use app\modules\order\models\OrderRel;
use Yii;
use app\modules\grave\models\Portrait;
use app\modules\grave\models\search\PortraitSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PortraitController implements the CRUD actions for Portrait model.
 */
class PortraitController extends BackController
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
            'pl-upload' => [
                'class' => 'app\core\web\PluploadAction',
            ],
        ];
    }


    /**
     * @param $info
     * @return bool|null
     * @name 保存图片
     */
    public function saveAttach($info)
    {

        $portrait = Portrait::findOne($info['res_id']);

        if (!$portrait) {
            return null;
        }

        return $portrait->saveAttach($info);
    }

    /**
     * Lists all Portrait models.
     * @return mixed
     * @name 瓷像列表
     */
    public function actionIndex()
    {
        $searchModel = new PortraitSearch();
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
            'tomb.tomb_no',
            'title',
//             [
//                 'label' => '瓷像',
//                 'value' => function($model){
//                     return $model->sku->getName();
//                 }
//             ],
            [
                'label' => '使用人',
                'value' => function($model) {
                    $dead = $model->getDeads();
                    return implode(ArrayHelper::getColumn($dead, 'dead_name'),',');
                }
            ],

            [
                'headerOptions' => ["data-breakpoints"=>"all"],
                'label' => '导购',
                'value' => function($model){
                    return $model->guide->username;
                },
                'format' => 'ntext'
            ],

            [
                'headerOptions' => ["data-breakpoints"=>"all"],
                'label' => '备注',
                'value' => function($model){
                    return $model->note;
                },
                'format' => 'ntext'
            ],

            [
                'headerOptions' => ["data-type"=>"html"],
                'label' => '瓷像状态',
                'value' => function($model){
                    return '<span class="status-text">' . $model->statusText . '</span>';
                },
                'format' => 'raw',
                'options' => ['class'=>'abc']
            ],
            'use_at:date',
            'statusText',
        ];

        $options = [
            'title'=>'瓷像',
            'filename'=>'portrait',
            'pageTitle'=>'瓷像'
        ];
        \app\core\libs\Export::export($dp, $columns, $options);
    }

    /**
     * Displays a single Portrait model.
     * @param integer $id
     * @return mixed
     * @name 瓷像详情
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Portrait model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 添加
     */
    public function actionCreate()
    {
        $model = new Portrait();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Portrait model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @name 修改
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
     * Deletes an existing Portrait model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Portrait::STATUS_DELETE;
        $model->save();
        return $this->redirect(['index']);
    }

    public function actionDel()
    {
        $post = Yii::$app->request->post();
        $model = $this->findModel($post['id']);
        $model->status = Portrait::STATUS_DELETE;
        if ($model->save()) {
            $order_rel = OrderRel::findOne($model->order_rel_id);
            if ($order_rel) {
                $order_rel->status = OrderRel::STATUS_DELETE;
                $order_rel->save();
                $order_rel->order->updatePrice();
            }

            return $this->json();
        }

        return $this->json(null, '瓷像删除失败,请联系管理员，或在瓷像管理页面删除', 0);

    }


    /**
     * @param $id
     * @return array
     * @name 修改状态为完成
     */
    public function actionComplete($id)
    {
        $model = $this->findModel($id);
        $model->status = Portrait::STATUS_COMPLETE;
        if ($model->save()) {
            return $this->json();
        }
        return $this->json(null, '操作失败，请重试', 0);
    }

    /**
     * Finds the Portrait model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Portrait the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Portrait::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
