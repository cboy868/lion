<?php

namespace app\modules\cms\controllers\admin;

use Yii;
use app\modules\cms\models\Message;
use app\modules\cms\models\MessageSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MessageController implements the CRUD actions for Message model.
 */
class MessageController extends BackController
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
     * Lists all Message models.
     * @return mixed
     * @name 留言列表
     */
    public function actionIndex()
    {
        $searchModel = new MessageSearch();
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
            'title',
            'username',
            'mobile',
            [
                'headerOptions' => ["data-type"=>"html"],
                'label' => 'Email',
                'value' => function($model){
                    return $model->email;
                },
                'format' => 'email'
            ],
            [
                'headerOptions' => ["data-type"=>"html"],
                'label' => '处理人',
                'value' => function($model){
                    if ($model->op_id) {
                        return $model->user->username;
                    }

                    return '';
                },
            ],
            [
                'headerOptions' => ["data-breakpoints"=>"all"],
                'label' => 'QQ',
                'value' => function($model){
                    return $model->qq;
                },
            ],
            [
                'headerOptions' => ["data-breakpoints"=>"all"],
                'label' => 'Skype',
                'value' => function($model){
                    return $model->skype;
                },
            ],
            [
                'headerOptions' => ["data-breakpoints"=>"all"],
                'label' => '主内容',
                'value' => function($model){
                    return $model->intro;
                },
                'format' => 'raw'
            ],
        ];

        $options = [
            'title'=>'留言',
            'filename'=>'message',
            'pageTitle'=>'留言'
        ];
        \app\core\libs\Export::export($dp, $columns, $options);
    }

    /**
     * @param $id
     * @return array
     * @name 处理
     */
    public function actionDeal($id)
    {
        $model = $this->findModel($id);
        $model->status = Message::STATUS_OK;
        $model->op_id = Yii::$app->user->id;
        if ($model->save()) {
            return $this->json();
        }

        return $this->json(null, null, 0);
    }

    /**
     * Displays a single Message model.
     * @param integer $id
     * @return mixed
     * @name 详细
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Message model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new Message();
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
     * Updates an existing Message model.
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
     * Deletes an existing Message model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除留言
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @return array
     * @name 批量删除
     */
    public function actionBatchDel()
    {
        $post = Yii::$app->request->post();

        $ses = Yii::$app->getSession();

        if (empty($post['ids'])) {
            return $this->json(null, '请选择要删除的数据 ', 0);
        }

        $outerTransaction = Yii::$app->db->beginTransaction();

        try{
            //删除商品
            Yii::$app->db->createCommand()
                ->delete(Message::tableName(),[
                    'id' => $post['ids']
                ])->execute();

            $outerTransaction->commit();

        } catch (\Exception $e){
            $outerTransaction->rollBack();
            return $this->json(null, '删除失败', 0);
        }

        $ses->setFlash('success','数据批量删除成功');
        return $this->json();

    }

    /**
     * Finds the Message model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Message the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Message::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
