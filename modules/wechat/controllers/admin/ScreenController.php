<?php

namespace app\modules\wechat\controllers\admin;

use Yii;
use app\modules\wechat\models\Screen;
use app\modules\wechat\models\ScreenSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ScreenController implements the CRUD actions for Screen model.
 */
class ScreenController extends BackController
{
    public $actions = ['delete','open','stop','start', 'static', 'refresh'];

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
     * Lists all Screen models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ScreenSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Screen model.
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
     * Creates a new Screen model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Screen();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Screen model.
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
     * Deletes an existing Screen model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionOption($id=0)
    {
        $post = Yii::$app->request->post();
        $action = $post['action'];

        if (!in_array($action, $this->actions)) {
            $this->json(null, '无此操作', 0);
        }

        if ($action == 'delete' && !$this->actionDelete($id)) {
            $this->json(null, '删除失败', 0);
        }

        if ($action == 'open' && !Screen::push([$id])) {
            $this->json(null, '展开失败', 0);
        }

        $data = [
            'id' => $id,
            'action' => $action
        ];

        $screen_url = Yii::$app->getModule('wechat')->params['screen_url'];

        $data = json_encode($data);
        $res = Screen::request_by_post($screen_url . '/option', $data);

        if ($res == 'ok') {
            $this->json(null, '操作成功', 1);
        }

        $this->json(null, '操作失败', 0);

    }


    /**
     * 大屏公告
     * ['id'=>1, 'notice'=>'abc','date'=>'2015.05.21']
     */
    public function actionAnnounce()
    {
        $announce = $_POST['announce'];

        $data = [
            'user_id' => Yii::$app->user->id,
            'content' => $announce,
            'created_at'=> time()
        ];//组织数据

//        $id = M('announce')->add($data);

        $push = [
            'id' => time(),
            'notice' => $announce
        ];

        $screen_url = Yii::$app->getModule('wechat')->params['screen_url'];

        $res = Screen::request_by_post($screen_url . '/notice', json_encode($push));

        if ($res == 'ok') {
            $this->json(null, '通知发送成功', 1);
        }

        $this->json(null, '通知发送失败', 0);

    }

    public function actionMsg($id)
    {
        if (!is_array($id)) {
            $id = [$id];
        }
        $res = Screen::push($id);
        if ($res) {
            $this->json(null, '信息推送成功', 1);
        }
        $this->json(null, '信息推送失败', 0);

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
            Yii::$app->db->createCommand()
                ->delete(Screen::tableName(),[
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
     * Finds the Screen model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Screen the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Screen::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
