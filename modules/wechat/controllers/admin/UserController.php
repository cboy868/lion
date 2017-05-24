<?php

namespace app\modules\wechat\controllers\admin;

use app\core\base\Pagination;
use app\core\helpers\ArrayHelper;
use Yii;
use app\modules\wechat\models\User;
use app\modules\wechat\models\UserSearch;

use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use EasyWeChat\Foundation\Application;
/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     * @name 微信用户列表
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @name 微信用户详情
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionPull()
    {
        //最开始 应该先清空表
        $userService = $this->app->user;

        Yii::$app->db->createCommand()->truncateTable(User::tableName());

        $next=null;
        $time = time();
        do {
            $users = $userService->lists($next);
            $count = $users->count;
            $next = $users->next_openid;
            $total = $users->total;
            $list = $users->data['openid'];

            $result = [];

            foreach ($list as $v){
                $result[] = [$v, $time];
            }

            Yii::$app->db->createCommand()
                        ->batchInsert(User::tableName(), ['openid', 'created_at'], $result)
                        ->execute();

        } while($count != 0 && $total>$count);

        return $this->redirect(['sync']);
    }


    /**
     * @name 同步用户数据
     */
    public function actionSync()
    {
        ob_flush();
        flush();
        $query = User::find();
        $count = $query->count();
        $pagination = new Pagination(['totalCount'=>$count, 'pageSize'=>1]);
        $links = $pagination->getLinks();

        $list = $query->offset($pagination->offset)
                        ->limit($pagination->limit)
                        ->asArray()
                        ->all();


        $open_ids = ArrayHelper::getColumn($list, 'openid');

        $users_info = $this->app->user->batchGet($open_ids);
        $ulist = $users_info['user_info_list'];

        if ($ulist) {
            foreach ($users_info['user_info_list'] as $u) {
                $model = User::find()->where(['openid'=>$u['openid']])->one();
                $model->load($u, '');
                $model->gid = $u['groupid'];
                $model->subscribe_at = $u['subscribe_time'];
                $model->save();
            }
        }

        if ($pagination->getPage() < $pagination->getPageCount() && isset($links[Pagination::LINK_NEXT])) {
            return $this->redirect($links[Pagination::LINK_NEXT]);

        }

        Yii::$app->session->setFlash('success', '拉取成功');

        return $this->redirect(['index']);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 添加
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
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
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
