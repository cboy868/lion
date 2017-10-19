<?php

namespace app\modules\agency\controllers\admin;

use app\core\base\Upload;
use app\core\helpers\ArrayHelper;
use app\modules\agency\models\SearchUser;
use app\modules\agency\models\UpdateForm;
use app\modules\agency\models\UpdateUser;
use app\modules\sys\models\Menu;
use app\modules\user\models\MenuRel;
use Yii;
use app\modules\user\models\User;
use app\modules\agency\models\UserForm;
use app\modules\user\models\UserField;
use app\modules\user\models\Addition;
use app\modules\user\models\UserSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use app\modules\user\models\Log;

/**
 * DefaultController implements the CRUD actions for User model.
 */
class AgentController extends BackController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'drop' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     * @name 业务员管理
     */
    public function actionIndex()
    {
        $searchModel = new SearchUser();

        $params = Yii::$app->request->queryParams;
        $params['SearchUser']['is_staff'] = User::STAFF_AGENT;
        $dataProvider = $searchModel->search($params);

        if (isset($params['excel']) && $params['excel']){
            return $this->excel($dataProvider);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    private function excel($dp)
    {
        $columns = ['username','mobile', 'email','created_at:datetime'];
        $options = [
            'title'=>'账号',
            'filename'=>'user',
            'pageTitle'=>'账号表'
        ];
        \app\core\libs\Export::export($dp,$columns, $options);
    }

    /**
     * @name 导入数据
     */
    public function actionImport()
    {
        $upload = Upload::getFileInstanceByName('users');

        $upload->saveFile();

        $info = $upload->getInfo();

        $path = $info['path'] .'/'. $info['fileName'];
        $rel_path = Yii::getAlias('@app/web') . $path;


        \app\core\libs\PHPExcel::import($rel_path);


//        $info = $upload->getInfo();
//
//        $post = Yii::$app->getRequest()->post();
//        $id = $post['id'];
//        $model = Menu::findOne($id);
//        $model->ico = $info['path'] . '/' . $info['fileName'];
    }


    /**
     * @name 删除非活跃用户
     * 假删除
     */
    public function actionDrop()
    {
        $users = Log::nonActiveUsers(185, 2);
        User::dropBatch($users);

        Yii::$app->getSession()->setFlash('success', '操作成功');
        return $this->redirect(['index']);
    }
  
    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @name 用户详情
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'addition' => $this->findAddition($id),
            'attach' => UserField::find()->asArray()->all()
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 添加新用户
     */
    public function actionCreate()
    {
        $model = new UserForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $outerTransaction = Yii::$app->db->beginTransaction();
            try {
                $user = $model->create();
                $addition = new Addition();
                $addition->user_id = $user->id;
                $addition->save();

                $outerTransaction->commit();
            } catch (\Exception $e) {
                echo $e->getMessage();
                $outerTransaction->rollBack();
            }

            return $this->redirect(['index']);
        } else {
            $model->is_staff = User::STAFF_AGENT;
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
       
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @name 修改用户信息
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $addition = $this->findAddition($id);

        $attach = UserField::find()->asArray()->all();

        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->validate()) {

            $outerTransaction = Yii::$app->db->beginTransaction();
            try {
                $addition->load($post);
                $model->save();
                $addition->save();

                $outerTransaction->commit();
            } catch (\Exception $e) {
                Yii::error($e->getMessage());
                $outerTransaction->rollBack();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'attach' => $attach,
                'addition' => $addition,
            ]);
        }
    }



    /**
     * Deletes an existing User model.  
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除用户
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = User::STATUS_DELETED;
        $model->save();

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
            Yii::$app->db->createCommand()
                ->delete(User::tableName(),[
                    'id' => $post['ids']
                ])->execute();

            Yii::$app->db->createCommand()
                ->delete(Addition::tableName(),[
                    'user_id' => $post['ids']
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UpdateUser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findAddition($user_id)
    {
        if (($model = Addition::findOne($user_id)) !== null) {
            return $model;
        } else {
            $model = new Addition();
            $model->user_id = $user_id;
            if ($model->save()) {
                return $this->findAddition($user_id);
            }


            throw new NotFoundHttpException('The requested page does not exist.');

        }
    }
}