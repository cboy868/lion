<?php

namespace app\modules\cms\controllers\admin;

use app\modules\cms\models\AlbumImageSearch;
use Yii;
use app\core\helpers\ArrayHelper;
use app\modules\cms\models\Post;
use app\modules\cms\models\PostForm;
use app\modules\cms\models\PostSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\mod\models\Module;
use app\modules\mod\models\Code;
use app\modules\cms\models\AlbumImage;

use app\modules\cms\models\Category;
use app\core\helpers\Url;
use app\core\base\Upload;
use app\core\helpers\Html;

class DefaultController extends \app\core\web\BackController
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
            'web-upload' => [
                'class' => 'app\core\web\WebuploadAction',
            ],
            'ue-upload' => [
                'class' => 'app\core\widgets\Ueditor\UploadAction',
            ],
            'album-upload' => [
                'class' => 'app\core\web\AlbumUploadAction',
            ]
        ];
    }

    /**
     * @return string
     * @name 内容管理
     */
    public function actionIndex($id, $type="post")
    {
        $cate = Category::findOne($id);

        $method = '_' . $type . 'List';
        $data = $this->$method($cate->res_name);


        return $this->render('index', array_merge([
            'type' => $type,
            'cate'=>$cate
        ], $data));
    }

    private function _postList($mod)
    {
        $tree = $this->getCates($mod);

//        $modInfo = Module::findOne($mod);

        Code::createObj('post', $mod);

        $c = 'Post' . $mod . 'Search';
        $class = '\app\modules\cms\models\mods\\' . $c;

        $searchModel = new $class;

        $params = Yii::$app->request->queryParams;

        if (isset($params['category_id'])) {
            $params[$c]['category_id'] = $params['category_id'];
        }

        $dataProvider = $searchModel->search($params);


        $data = [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
//            'modinfo' => $modInfo,
            'cates'       => $tree,
            'current_cate' => Yii::$app->getRequest()->get('category_id')
        ];

        return $data;
    }

    private function _albumList($mod)
    {
        $tree = $this->getCates($mod);

        Code::createObj('album', $mod);

        $class = '\app\modules\cms\models\mods\Album' . $mod . 'Search';
        $c = 'Album' . $mod . 'Search';

        $searchModel = new $class;

        $params = Yii::$app->request->queryParams;
        $params[$c]['category_id'] = Yii::$app->request->get('category_id');
        $dataProvider = $searchModel->search($params);

        return [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cates'         => $tree,
            'current_cate' => Yii::$app->getRequest()->get('category_id')
        ];
    }



    /**
     * @name 获取分类
     */
    private function getCates($mod)
    {
        $res_name = $mod;
        $tree = Category::sortTree(['res_name'=>$res_name]);

        foreach ($tree as $k => &$v) {
            $v['url'] = $v['is_leaf'] ? Url::toRoute(['index', 'category_id'=>$v['id'], 'mod'=>$mod]) : '#';
        }

        $tree = \yii\helpers\ArrayHelper::index($tree, 'id');
        $tree = \app\core\helpers\Tree::recursion($tree,0,1);

        return $tree;
    }


    /**
     * @name 添加分类
     */
    public function actionCreateCate()
    {
        return $this->render('create-cate');
    }

    /**
     * @name 修改分类
     */
    public function actionUpdateCate()
    {
        return $this->render('update-cate');
    }

    /**
     * @name 添加内容
     */
    public function actionCreate($mod, $type)
    {
        $method = '_create' . ucfirst($type);
        return $this->$method($mod);
    }

    private function _createPost($mod)
    {
        Code::createObj('post', $mod);

        $class = '\app\modules\cms\models\mods\Post' . $mod;
        $model = new $class;
        $dataClass = '\app\modules\cms\models\mods\PostData' . $mod;
        $dataModel = new $dataClass;


        $modInfo = Category::findOne($mod);

        $command = (new \yii\db\Query())
            // ->select(['id', 'email'])
            ->from('module_field')
            ->where(['table' => 'post_' . $mod])
            ->createCommand();

        // 返回查询结果的所有行
        $attach = $command->queryAll();

        if ($model->load(Yii::$app->request->post()) ) {

            $model->ip = Yii::$app->request->userIP;
            $model->created_by = Yii::$app->user->identity->id;


            if (empty($model->summary)) {
                $body = Yii::$app->request->post('PostData'.$mod)['body'];
                $model->summary = Html::cutstr_html($body, 50);
            }

            $up = Upload::getInstance($model, 'thumb', 'post'.$mod);
            if ($up) {
                $up->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);
                $up->save();
                $info = $up->getInfo();
                $model->thumb = $info['mid'];
            }

            $model->save();

            $class = '\app\modules\cms\models\mods\PostData' . $mod;
            $data = new $class;
            $data->post_id = $model->id;
            $data->body = Yii::$app->request->post('PostData'.$mod)['body'];

            $data->save();

            return $this->redirect(['index', 'id' => $modInfo->id]);
        } else {

            return $this->render('create', [
                'model' => $model,
                'attach'=> $attach,
                'modInfo' => $modInfo,
                'dataModel' => $dataModel
            ]);
        }

    }

    private function _createAlbum($mod)
    {
//        $modInfo = Module::findOne($mod);
        $modInfo = Category::findOne($mod);
        Code::createObj('album', $mod);

        $command = (new \yii\db\Query())
            // ->select(['id', 'email'])
            ->from('module_field')
            ->where(['table' => 'album_' . $mod])
            ->createCommand();

        // 返回查询结果的所有行
        $attach = $command->queryAll();

        $class = '\app\modules\cms\models\mods\Album' . $mod;;

        $model = new $class();

        if ($model->load(Yii::$app->request->post()) ) {

            $model->created_by = Yii::$app->user->identity->id;
            $model->save();
            return $this->redirect(['album-view', 'mod'=>$mod, 'id'=>$model->id]);
        } else {
            $model->author = Yii::$app->user->identity->username;
            return $this->renderAjax('create', [
                'model' => $model,
                'modInfo' => $modInfo,
                'attach'=> $attach,
            ]);
        }
    }


    /**
     * @name 修改内容
     */
    public function actionUpdate($type, $mod, $id)
    {
        $method = '_update' . ucfirst($type);
        return $this->$method($id, $mod);
    }

    private function _updatePost($id, $mod)
    {
        $model = $this->findPost($id, $mod);
        $class = '\app\modules\cms\models\mods\PostData' . $mod;
        $dataModel = $class::find()->where(['post_id'=>$id])->one();
        $dataModel = $dataModel ? $dataModel : new $class;


//        $modInfo = Module::findOne($mod);
        $modInfo = Category::findOne($mod);

        $attach = [];
        if ($mod) {
            $command = (new \yii\db\Query())
                // ->select(['id', 'email'])
                ->from('module_field')
                ->where(['table' => 'post_' . $mod])
                ->createCommand();

            // 返回查询结果的所有行
            $attach = $command->queryAll();
        }

        if ($model->load(Yii::$app->request->post()) && $dataModel->load(Yii::$app->request->post())) {

            $up = Upload::getInstance($model, 'thumb', 'post'.$mod);
            if ($up) {
                $up->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);
                $up->save();
                $info = $up->getInfo();
                $model->thumb = $info['mid'];
            }

            $summary = strip_tags($model->summary);


            if (empty($summary)) {
                $body = Yii::$app->request->post('PostData'.$mod)['body'];
                $model->summary = Html::cutstr_html($body, 50);
            }

            $model->save();
            $dataModel->save();

            return $this->redirect(['index', 'id'=>$mod]);
        } else {

            return $this->render('update', [
                'model' => $model,
                'attach'=> $attach,
                'modInfo' => $modInfo,
                'dataModel' => $dataModel
            ]);
        }
    }

    private function _updateAlbum($id, $mod)
    {
        $model = $this->findAlbum($id, $mod);

        $command = (new \yii\db\Query())
            ->from('module_field')
            ->where(['table' => 'album_' . $mod])
            ->createCommand();

        // 返回查询结果的所有行
        $attach = $command->queryAll();

//        $modInfo = Module::findOne($mod);
        $modInfo = Category::findOne($mod);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id'=>$mod]);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
                'modInfo' => $modInfo,
                'attach'=> $attach,
            ]);
        }
    }

    public function actionAlbumView($mod, $id)
    {
        $cate = Category::findOne($mod);
        $searchModel = new AlbumImageSearch();
        $params = Yii::$app->request->queryParams;
        $params['AlbumImageSearch']['mod'] = $mod;
        $params['AlbumImageSearch']['album_id'] = $id;

        $dataProvider = $searchModel->search($params);

        return $this->render('album-view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'album' => $this->findAlbum($id, $mod),
            'cate' => $cate,
        ]);
    }

    public function actionPostView($id, $mod)
    {
        return $this->render('post-view', [
            'model' => $this->findPost($id, $mod),
            'modInfo' => Category::findOne($mod)
        ]);
    }

    /**
     * @param $id
     * @param $mod
     * @return \yii\web\Response
     * @name 删除图集
     */
    public function actionDeleteAlbum($id, $mod)
    {
        $this->findAlbum($id, $mod)->delete();

        Yii::$app->db->createCommand()
            ->update(
                AlbumImage::tableName(),
                ['status' => -1],
                ['album_id'=>$id, 'mod'=>$mod])
            ->execute();

        return $this->redirect(['index', 'id'=>$mod,'type'=>'album']);
    }


    /**
     * @param $id
     * @param $mod
     * @return \yii\web\Response
     * @name 删除文章
     */
    public function actionDeletePost($id, $mod)
    {
        $this->findPost($id, $mod)->delete();

        return $this->redirect(['index', 'id'=>$mod, 'type'=>'post']);
    }

    /**
     * @return array
     * @name 修改图片名及描述
     */
    public function actionTitDes()
    {
        $post = Yii::$app->request->post();

        $tit = $post['title'];
        $des = $post['desc'];
        $id  = $post['id'];

        $model = AlbumImage::findOne($id);
        $model->title = $tit;
        $model->desc = $des;
        if ($model->save()) {
            return $this->json();
        }

        return $this->json(null, null, 0);
    }

    /**
     * Deletes an existing Album model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除图集中图片
     */
    public function actionDelImg($id, $mod, $album_id)
    {
        $this->findImg($id)->delete();
        $model = $this->findAlbum($album_id, $mod);
        $model->updateNum();
        return $this->redirect(['album-view', 'mod'=>$mod, 'id'=>$album_id]);
    }

    /**
     * @name 排序
     */
    public function actionSort($mod, $album_id)
    {
        $ids = Yii::$app->request->post('ids');

        $connection = Yii::$app->db;

        foreach ($ids as $k => $v) {
            $connection->createCommand()
                ->update(
                    AlbumImage::tableName(),
                    ['sort' => $k],
                    ['id'=>$v])
                ->execute();
        }

        return $this->json();
    }

    public function actionCover($mod, $album_id, $id)
    {
        $model = $this->findAlbum($album_id, $mod);
        $model->thumb = $id;
        $model->save();

        return $this->json();
    }


    protected function findPost($id, $mod)
    {

        Code::createObj('post', $mod);


        $class = '\app\modules\cms\models\mods\Post' . $mod;
        if (($model = $class::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findAlbum($id, $mod)
    {

        Code::createObj('album', $mod);


        $class = '\app\modules\cms\models\mods\Album' . $mod;
        if (($model = $class::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findImg($id)
    {
        if (($model = AlbumImage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
