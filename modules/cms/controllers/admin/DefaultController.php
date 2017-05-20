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
    public function actionIndex($mid, $type="post")
    {
        $module = Module::findOne($mid);

        $method = '_' . $type . 'List';
        $data = $this->$method($module->id);

        return $this->render('index', array_merge([
            'type' => $type,
            'module'=>$module
        ], $data));
    }

    private function _postList($mid)
    {

        $module = Module::findOne($mid);

        Code::createObj('post', $mid);

        $c = 'Post' . $mid . 'Search';
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
            'module' => $module,
        ];

        return $data;
    }

    private function _albumList($mid)
    {

        Code::createObj('album', $mid);

        $class = '\app\modules\cms\models\mods\Album' . $mid . 'Search';
        $c = 'Album' . $mid . 'Search';

        $searchModel = new $class;

        $params = Yii::$app->request->queryParams;
        $params[$c]['category_id'] = Yii::$app->request->get('category_id');
        $dataProvider = $searchModel->search($params);

        $module = Module::findOne($mid);
        return [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'module' => $module,
        ];
    }

    /**
     * @name 添加内容
     */
    public function actionCreate($mid, $type)
    {
        $method = '_create' . ucfirst($type);
        return $this->$method($mid);
    }

    private function _createPost($mid)
    {
        Code::createObj('post', $mid);

        $class = '\app\modules\cms\models\mods\Post' . $mid;
        $model = new $class;
//        $dataClass = '\app\modules\cms\models\mods\PostData' . $mid;
//        $dataModel = new $dataClass;


        $module = Module::findOne($mid);

        $command = (new \yii\db\Query())
            ->from('module_field')
            ->where(['table' => 'post_' . $mid])
            ->createCommand();

        // 返回查询结果的所有行
        $attach = $command->queryAll();

        if ($model->load(Yii::$app->request->post()) ) {

            $model->ip = Yii::$app->request->userIP;
            $model->created_by = Yii::$app->user->identity->id;


            if (empty($model->summary)) {
                $model->summary = Html::cutstr_html($model->body, 50);
            }

            $up = Upload::getInstance($model, 'thumb', 'post'.$mid);
            if ($up) {
                $up->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);
                $up->save();
                $info = $up->getInfo();
                $model->thumb = $info['mid'];
            }

            $model->save();

            return $this->redirect(['index', 'mid' => $module->id]);
        } else {

            return $this->render('create', [
                'model' => $model,
                'attach'=> $attach,
                'module' => $module,
            ]);
        }

    }

    private function _createAlbum($mid)
    {
        $module = Module::findOne($mid);
        Code::createObj('album', $mid);

        $command = (new \yii\db\Query())
            // ->select(['id', 'email'])
            ->from('module_field')
            ->where(['table' => 'album_' . $mid])
            ->createCommand();

        // 返回查询结果的所有行
        $attach = $command->queryAll();

        $class = '\app\modules\cms\models\mods\Album' . $mid;;

        $model = new $class();

        if ($model->load(Yii::$app->request->post()) ) {

            $model->created_by = Yii::$app->user->identity->id;
            $model->save();
            return $this->redirect(['album-view', 'mid'=>$mid, 'id'=>$model->id]);
        } else {
            $model->author = Yii::$app->user->identity->username;
            return $this->renderAjax('create', [
                'model' => $model,
                'module' => $module,
                'attach'=> $attach,
            ]);
        }
    }


    /**
     * @name 修改内容
     */
    public function actionUpdate($type, $mid, $id)
    {
        $method = '_update' . ucfirst($type);
        return $this->$method($id, $mid);
    }

    private function _updatePost($id, $mid)
    {
        $model = $this->findPost($id, $mid);

        $mInfo = Module::findOne($mid);

        $attach = [];
        if ($mid) {
            $command = (new \yii\db\Query())
                        // ->select(['id', 'email'])
                        ->from('module_field')
                        ->where(['table' => 'post_' . $mid])
                        ->createCommand();

            // 返回查询结果的所有行
            $attach = $command->queryAll();
        }

        if ($model->load(Yii::$app->request->post())) {


            $up = Upload::getInstance($model, 'thumb', 'post'.$mid);
            if ($up) {
                $up->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);
                $up->save();
                $info = $up->getInfo();
                $model->thumb = $info['mid'];
            }

            $summary = strip_tags($model->summary);


            if (empty($summary)) {
                $model->summary = Html::cutstr_html($model->body, 50);
            }

            $model->save();

            return $this->redirect(['index', 'mid'=>$mid]);
        } else {

            return $this->render('update', [
                'model' => $model,
                'attach'=> $attach,
                'mInfo' => $mInfo,
            ]);
        }
    }

    private function _updateAlbum($id, $mid)
    {
        $model = $this->findAlbum($id, $mid);

        $command = (new \yii\db\Query())
                    ->from('module_field')
                    ->where(['table' => 'album_' . $mid])
                    ->createCommand();

        // 返回查询结果的所有行
        $attach = $command->queryAll();

        $module = Module::findOne($mid);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'mid'=>$mid, 'type'=>'album']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
                'mInfo' => $module,
                'attach'=> $attach,
            ]);
        }
    }

    public function actionAlbumView($mid, $id)
    {
        $module = Module::findOne($mid);
        $searchModel = new AlbumImageSearch();
        $params = Yii::$app->request->queryParams;
        $params['AlbumImageSearch']['mid'] = $mid;
        $params['AlbumImageSearch']['album_id'] = $id;

        $dataProvider = $searchModel->search($params);

        return $this->render('album-view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'album' => $this->findAlbum($id, $mid),
            'module' => $module,
        ]);
    }

    public function actionPostView($id, $mid)
    {
        return $this->render('post-view', [
            'model' => $this->findPost($id, $mid),
            'mInfo' => Module::findOne($mid)
        ]);
    }

    /**
     * @param $id
     * @param $mod
     * @return \yii\web\Response
     * @name 删除图集
     */
    public function actionDeleteAlbum($id, $mid)
    {
        $this->findAlbum($id, $mid)->delete();

        Yii::$app->db->createCommand()
            ->update(
                AlbumImage::tableName(),
                ['status' => -1],
                ['album_id'=>$id, 'mod'=>$mid])
            ->execute();

        return $this->redirect(['index', 'mid'=>$mid,'type'=>'album']);
    }


    /**
     * @param $id
     * @param $mod
     * @return \yii\web\Response
     * @name 删除文章
     */
    public function actionDeletePost($id, $mid)
    {
        $this->findPost($id, $mid)->delete();

        return $this->redirect(['index', 'id'=>$mid, 'type'=>'post']);
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
    public function actionDelImg($id, $mid, $album_id)
    {
        $this->findImg($id)->delete();
        $model = $this->findAlbum($album_id, $mid);
        $model->updateNum();
        return $this->redirect(['album-view', 'mid'=>$mid, 'id'=>$album_id]);
    }

    /**
     * @name 排序
     */
    public function actionSort($album_id)
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

    public function actionCover($mid, $album_id, $id)
    {
        $model = $this->findAlbum($album_id, $mid);
        $model->thumb = $id;
        $model->save();

        return $this->json();
    }


    protected function findPost($id, $mid)
    {

        Code::createObj('post', $mid);

        $class = '\app\modules\cms\models\mods\Post' . $mid;
        if (($model = $class::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findAlbum($id, $mid)
    {

        Code::createObj('album', $mid);


        $class = '\app\modules\cms\models\mods\Album' . $mid;
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
