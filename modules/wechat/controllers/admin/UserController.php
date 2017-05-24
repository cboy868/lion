<?php

namespace app\modules\wechat\controllers\admin;

use app\core\base\Pagination;
use app\core\helpers\ArrayHelper;
use app\modules\wechat\models\TagRel;
use Yii;
use app\modules\wechat\models\User;
use app\modules\wechat\models\Tag;
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
    public function actionIndex($tagid=null)
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);



        $tags = Tag::find()->all();
        $tag = Tag::findOne($tagid);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tags' => $tags,
            'tagid' =>$tagid,
            'tag' => $tag
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

        Yii::$app->db->createCommand()->truncateTable(User::tableName())->execute();

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

    /**
     * @name 同步标签信息
     */
    public function actionSyncTag()
    {
        $tag = $this->app->user_tag;
        $list = $tag->lists();

        //找出本库里所有tag
        $localTags = Tag::find()->where(['wid'=>$this->wid])
                                ->indexBy('tag_id')
                                ->all();


        $outerTransaction = Yii::$app->db->beginTransaction();
        try {
            //远程到本地
            foreach ($list['tags'] as $v) {
                $model = Tag::find()->where(['tag_id'=>$v['id']])
                                    ->andWhere(['wid'=>$this->wid])
                                    ->one();
                if (!$model) {
                    $model = new Tag();
                    $model->wid = $this->wid;
                    $model->tag_id = $v['id'];
                }
                $model->name = $v['name'];
                $model->save();
                unset($localTags[$v['id']]);
            }
            //本地到远程
            foreach ($localTags as $v) {
                $tag_info = $tag->create($v->name);
                if (isset($tag_info['tag']['id'])) {
                    $v->tag_id = $tag_info['tag']['id'];
                    $v->save();
                } else {
                    $v->name = $v->name . '_wrong';
                    $v->save();
                }

            }
            $outerTransaction->commit();
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('success', '同步标签信息失败');
            return $this->error($e->getMessage());
            $outerTransaction->rollBack();
        }

        Yii::$app->session->setFlash('success', '同步标签信息成功');
        return $this->redirect(['index']);
    }



    private function _pullTagUser()
    {
        $tags = Tag::find()->where(['wid'=>$this->wid])->all();
        $tag = $this->app->user_tag;
        $outerTransaction = Yii::$app->db->beginTransaction();

        try {
            foreach ($tags as $v) {
                $next = null;
                do {
                    //取本地此标签下的粉丝
                    $rels = TagRel::find()->where(['wid'=>$this->wid])
                                ->andWhere(['tag_id'=>$v->tag_id])
                                ->indexBy('openid')
                                ->all();

                    $users = $tag->usersOfTag($v->tag_id, $next);
                    $count = $users->count;

                    if ($count) {
                        $next = $users->next_openid;
                        $list = $users->data['openid'];

                        foreach ($list as $val){
                            if (!array_key_exists($val, $rels)) {
                                $model = new TagRel();
                                $model->wid = $this->wid;
                                $model->tag_id = $v->tag_id;
                                $model->openid = $val;
                                $model->save();
                            }
                        }
                    }

                } while($count != 0);
            }
            $outerTransaction->commit();
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('success', '同步标签信息失败');
            return $this->error($e->getMessage());
            $outerTransaction->rollBack();
        }
    }

    private function _pushTagUser()
    {
        $tags = Tag::find()->where(['wid'=>$this->wid])->all();
        $tag = $this->app->user_tag;
        $outerTransaction = Yii::$app->db->beginTransaction();
        try {
            foreach ($tags as $v) {
                $rels = TagRel::find()->where(['wid'=>$this->wid])
                                ->andWhere(['tag_id'=>$v->tag_id])
                                ->indexBy('openid')
                                ->all();

                $openIds = ArrayHelper::getColumn($rels, 'openid');

                $a = $tag->batchTagUsers($openIds, $v->tag_id);
            }
            $outerTransaction->commit();
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('success', '同步标签信息失败');
            return $this->error($e->getMessage());
            $outerTransaction->rollBack();
        }
    }

    public function actionSyncTagUser1()
    {
        $this->_pullTagUser();
        $this->_pushTagUser();

        return $this->redirect(['index']);
    }

    /**
     * @name 同步粉丝标签
     */
    public function actionSyncTagUser()
    {
        $localTags = Tag::find()->where(['wid'=>$this->wid])
                                ->all();
        $tag = $this->app->user_tag;

//        $userTags = $tag->userTags('oziua0zmwYFotxHtW2J-Gr05hCJs');


//p($userTags);die;

        $outerTransaction = Yii::$app->db->beginTransaction();
        try {
            foreach ($localTags as $v) {
                $next = null;
                do {
                    //取本地此标签下的粉丝
                    $rels = TagRel::find()->where(['wid'=>$this->wid])
                                    ->andWhere(['tag_id'=>$v->tag_id])
                                    ->indexBy('openid')
                                    ->all();

                    $users = $tag->usersOfTag($v->tag_id, $next);

                    $count = $users->count;

                    if ($count) {
                        $next = $users->next_openid;
                        $list = $users->data['openid'];

                        foreach ($list as $val){
                            if (!array_key_exists($val, $rels)) {
                                $model = new TagRel();
                                $model->wid = $this->wid;
                                $model->tag_id = $v->tag_id;
                                $model->openid = $val;
                                $model->save();
                                unset($rels[$val]);
                            }
                        }
                    }

                    $openIds = array_keys($rels);
                    p($openIds);
                    p($v->tag_id);
                    $a = $tag->batchTagUsers($openIds, $v->tag_id);
                    p($a);die;

                } while($count != 0);

            }
            $outerTransaction->commit();
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('success', '同步标签信息失败');
            return $this->error($e->getMessage());
            $outerTransaction->rollBack();
        }

        Yii::$app->session->setFlash('success', '同步标签信息成功');

        return $this->redirect(['index']);
    }


    /**
     * @name 清空tag
     */
    public function actionEmptyTag()
    {

    }

    public function actionCreateTag()
    {
        $model = new Tag();

        if ($model->load(Yii::$app->request->post())) {
            $outerTransaction = Yii::$app->db->beginTransaction();
            try {
                $tag = $this->app->user_tag;
                $tag_info = $tag->create($model->name);
                $model->wid = $this->wid;
                $model->tag_id = $tag_info['tag']['id'];
                $model->save();
                $outerTransaction->commit();
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
                $outerTransaction->rollBack();
            }

            return $this->redirect(['index', 'tag' => $model->id]);
        } else {
            return $this->renderAjax('create-tag', [
                'model' => $model,
            ]);
        }

    }
}
