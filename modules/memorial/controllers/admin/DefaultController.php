<?php

namespace app\modules\memorial\controllers\admin;

use app\core\models\Comment;
use app\modules\blog\models\Album;
use app\modules\blog\models\AlbumPhoto;
use app\modules\blog\models\AlbumPhotoSearch;
use app\modules\blog\models\AlbumSearch;
use app\modules\blog\models\Blog;
use app\modules\blog\models\BlogSearch;
use app\modules\grave\models\Dead;
use app\modules\memorial\models\Remote;
use app\modules\memorial\models\RemoteSearch;
use yii;
use app\modules\memorial\models\Memorial;
use app\modules\memorial\models\MemorialSearch;
use app\core\base\Upload;
use yii\web\NotFoundHttpException;
use yii\base\Model;

class DefaultController extends \app\core\web\BackController
{
    public function actions()
    {
        return [
            'pl-upload' => [
                'class' => 'app\core\web\PluploadAction',
            ],
            'ue-upload' => [
                'class' => 'app\core\widgets\Ueditor\UploadAction',
            ],
            'album-upload' => [
                'class' => 'app\core\web\AlbumUploadAction',
                'type' =>'blog_album'
            ]
        ];
    }



    /**
     * @return string
     * @name 纪念馆列表
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;

        $params['MemorialSearch']['user_id'] = Yii::$app->user->id;
        $searchModel = new MemorialSearch();
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionManage()
    {
        return $this->render('manage');
    }


    /**
     * @name 添加纪念馆
     */
    public function actionCreate()
    {
    	$model = new Memorial();

        if ($model->load(Yii::$app->request->post()) ) {

            $model->user_id = Yii::$app->user->id;
            $model->status = Memorial::STATUS_APPLY;//待审核状态
            $model->save();
            return $this->redirect(['index']);
        } else {

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $id
     * @name 添加新逝者
     */
    public function actionCreateDead($id)
    {
        $model = new Dead();

        $req = Yii::$app->getRequest();

        if (Yii::$app->request->isPost) {
            $model->load($req->post());
            $model->memorial_id = $id;
            $model->user_id = Yii::$app->user->id;
            $model->tomb_id = 0;
            $model->is_alive = 0;

            if ($model->save() !== false) {
                Yii::$app->session->setFlash('success', '添加逝者成功');
            } else {
                Yii::$app->session->setFlash('error', '添加逝者失败,请重试或联系管理员');
            }

            return $this->redirect(['deads', 'id'=>$id]);
        }

        $dead_title = Yii::$app->getModule('grave')->params['dead_title'];
        $dead_titles = [];
        foreach ($dead_title as $title) {
            $dead_titles[$title] = $title;
        }

        return $this->renderAjax('create-dead', [
            'model' => $model,
            'dead_titles' => $dead_titles
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {

            if ($model->save() !== false) {
                Yii::$app->session->setFlash('success', '修改成功');
            } else {
                Yii::$app->session->setFlash('error', '修改失败');
            }
            return $this->redirect(['update', 'id'=>$id]);


        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $id
     * @name 逝者资料
     */
    public function actionDeads($id)
    {
        $memorial = $this->findModel($id);
        $deads = $memorial->deads;

        if (Yii::$app->request->isPost) {
            if (Model::loadMultiple($deads, Yii::$app->request->post()) && Model::validateMultiple($deads)) {
                foreach ($deads as $model) {
                    $model->save();
                }
                Yii::$app->session->setFlash('success', '逝者信息修改成功');
            }

        }
        $dead_title = Yii::$app->getModule('grave')->params['dead_title'];
        $dead_titles = [];
        foreach ($dead_title as $title) {
            $dead_titles[$title] = $title;
        }

        return $this->render('deads', [
            'model' => $memorial,
            'deads' => $deads,
            'dead_titles' => $dead_titles
        ]);
    }

    #< 档案及追思部分开始

    public function actionArchive($id)
    {
        $memorial = $this->findModel($id);

        $params = Yii::$app->request->queryParams;

        $params['BlogSearch']['user_id'] = Yii::$app->user->id;
        $params['BlogSearch']['res'] = Blog::RES_ARCHIVE;
        $params['BlogSearch']['memorial_id'] = $id;

        $searchModel = new BlogSearch();
        $dataProvider = $searchModel->search($params);

        return $this->render('archive', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $memorial
        ]);

    }

    public function actionCreateBlog($id, $res)
    {

        $model = new Blog();

        $req = Yii::$app->getRequest();

        if (Yii::$app->request->isPost) {
            $model->load($req->post());
            $model->memorial_id = $id;
            $model->created_by = Yii::$app->user->id;
            $model->is_customer = Yii::$app->user->identity->isStaff() ? 0 : 1;
            $model->ip = Yii::$app->request->getUserIP();

            if ($res == Blog::RES_MISS) {
                $redirect = 'miss';
                $note = '添加追思文章';
                $status = Yii::$app->params['blog']['missInitStatus'];
            } else if ($res == Blog::RES_ARCHIVE) {
                $redirect = 'archive';
                $note = '添加档案';
                $status = Yii::$app->params['blog']['archiveInitStatus'];
            }
            $model->status = $status;

            if ($model->save() !== false) {
                Yii::$app->session->setFlash('success', $note . '成功');
            } else {
                Yii::$app->session->setFlash('error', $note .'失败,请重试或联系管理员');
            }

            return $this->redirect([$redirect, 'id'=>$id]);
        }

        $model->privacy = Blog::PRIVACY_PUBLIC;
        $model->res = Yii::$app->request->get('res');
        return $this->renderAjax('create-blog', [
            'model' => $model,
        ]);
    }

    public function actionUpdateBlog($archive_id)
    {

        $model = Blog::findOne($archive_id);

        $req = Yii::$app->getRequest();

        if (Yii::$app->request->isPost) {
            $model->load($req->post());
            $model->ip = Yii::$app->request->getUserIP();
            $model->status = Blog::STATUS_VRIFY;


            if ($model->res == Blog::RES_MISS) {
                $redirect = 'miss';
                $note = '修改追思文章';
            } else if ($model->res == Blog::RES_ARCHIVE) {
                $redirect = 'archive';
                $note = '修改档案';
            }


            if ($model->save() !== false) {
                Yii::$app->session->setFlash('success', $note . '成功');
            } else {
                Yii::$app->session->setFlash('error', $note . '失败,请重试或联系管理员');
            }


            return $this->redirect([$redirect, 'id'=>$model->memorial_id]);
        }


        return $this->renderAjax('update-blog', [
            'model' => $model,
        ]);
    }

    public function actionViewBlog($archive_id)
    {

        $model = Blog::findOne($archive_id);

        return $this->renderAjax('view-blog', [
            'model' => $model,
        ]);
    }

    public function actionDelBlog($archive_id)
    {
        $model = Blog::findOne($archive_id);
        $model->delete();

        if ($model->res == Blog::RES_ARCHIVE) {
            return $this->redirect(['archive', 'id'=>$model->memorial_id]);
        } else if ($model->res == Blog::RES_MISS) {
            return $this->redirect(['miss', 'id'=>$model->memorial_id]);
        }

    }

    /**
     * @name 追忆文章
     */
    public function actionMiss($id)
    {

        $memorial = $this->findModel($id);

        $params = Yii::$app->request->queryParams;

        $params['BlogSearch']['user_id'] = Yii::$app->user->id;
        $params['BlogSearch']['res'] = Blog::RES_MISS;
        $params['BlogSearch']['memorial_id'] = $id;

        $searchModel = new BlogSearch();
        $dataProvider = $searchModel->search($params);

        return $this->render('miss', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $memorial
        ]);

    }

    #> 档案追忆文章部分结束

    public function actionAlbum($id)
    {
        $memorial = $this->findModel($id);

        $params = Yii::$app->request->queryParams;

        $params['AlbumSearch']['user_id'] = Yii::$app->user->id;
        $params['AlbumSearch']['memorial_id'] = $id;
        $searchModel = new AlbumSearch();
        $dataProvider = $searchModel->search($params);

        return $this->render('album', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $memorial
        ]);

    }

    public function actionCreateAlbum($id)
    {
        $model = new Album();

        $req = Yii::$app->getRequest();

        if (Yii::$app->request->isPost) {
            $model->load($req->post());
            $model->memorial_id = $id;
            $model->created_by = Yii::$app->user->id;
            $model->is_customer = Yii::$app->user->identity->isStaff() ? 0 : 1;
            $model->ip = Yii::$app->request->getUserIP();

            if ($model->save() !== false) {
                Yii::$app->session->setFlash('success', '添加相册成功');
            } else {
                Yii::$app->session->setFlash('error', '添加相册失败,请重试或联系管理员');
            }

            return $this->redirect(['album', 'id'=>$id]);
        }

        $model->privacy = Album::PRIVACY_PUBLIC;
        return $this->renderAjax('create-album', [
            'model' => $model,
        ]);

    }

    public function actionUpdateAlbum($id)
    {
        $model = Album::findOne($id);
        $req = Yii::$app->getRequest();


        if ($model->load($req->post())) {
            if ($model->save() !== false) {
                Yii::$app->session->setFlash('success', '修改相册成功');
            } else {
                Yii::$app->session->setFlash('error', '修改相册失败,请重试或联系管理员');
            }

            return $this->redirect(['album', 'id'=>$model->memorial_id]);
        }

        return $this->renderAjax('update-album',[
            'model' => $model
        ]);
    }

    public function actionPhotos($id)
    {

        $album = Album::findOne($id);
        $memorial = $this->findModel($album->memorial_id);
        $params = Yii::$app->request->queryParams;

        $params['AlbumPhotoSearch']['album_id'] = $id;
        $searchModel = new AlbumPhotoSearch();
        $dataProvider = $searchModel->search($params);

        return $this->render('photos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'album' => $album,
            'memorial' => $memorial
        ]);

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

        $model = AlbumPhoto::findOne($id);
        $model->title = $tit;
        $model->body = $des;
        if ($model->save()) {
            return $this->json();
        }

        return $this->json(null, null, 0);
    }

    public function actionSetAlbumCover($id)
    {
        $photo = AlbumPhoto::findOne($id);
        $album = Album::findOne($photo->album_id);
        $album->thumb = $id;
        $album->save();
        return $this->redirect(['photos', 'id'=>$album->id]);
    }

    public function actionDelPhoto($id)
    {
        $photo = AlbumPhoto::findOne($id);
        $photo->delete();
        return $this->redirect(['photos', 'id'=>$photo->album_id]);
    }

    public function actionDelAlbum($id)
    {
        $model = Album::findOne($id);
        $model->delete();
        return $this->redirect(['album', 'id'=>$model->memorial_id]);
    }

    public function actionMsg($id)
    {
        $memorial = $this->findModel($id);
        $comment = new Comment();


        //取评论
        $comments = Comment::getByRes('memorial', $id, 15, '36x36');


        return $this->render('msg',[
            'model' => $memorial,
            'comment' => $comment,
            'comments' => $comments
        ]);
    }

    public function actionRemote($id)
    {
        $searchModel = new RemoteSearch();
        $params = Yii::$app->request->queryParams;

        $params['RemoteSearch']['memorial_id'] = $id;
        $dataProvider = $searchModel->search($params);

        $memorial = $this->findModel($id);

        return $this->render('remote', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'memorial' => $memorial
        ]);
    }

    public function actionRemoteVideo($id, $remote_id)
    {
        $remote = Remote::findOne($remote_id);
        $memorial = $this->findModel($id);

        return $this->render('remote-video', [
            'remote' => $remote,
            'memorial' => $memorial
        ]);
    }

    public function actionCreateMsg($id)
    {
        $model = new Comment();
        $req = Yii::$app->getRequest();

        $model->content = $req->post('content');
        $model->res_name = 'memorial';
        $model->res_id = $id;
        $model->from = Yii::$app->user->id;
        $model->to = 0;
        $model->privacy = Comment::PRIVACY_PUBLIC;

        if ($model->save() !== false) {
            $result = Comment::getByRes('memorial', $id, 1);
            return $this->json($result);
        } else {


            return $this->json(null, '祝福留言失败,请重试或联系管理员', 0);
        }
    }

    public function actionDelMsg($id)
    {
        $model = Comment::findOne($id);
        if ($model->delete()) {
            Yii::$app->db->createCommand()
                ->delete(Comment::tableName(),[
                    'pid' => $id,
                ])
                ->execute();
            return $this->json();
        }
        return $this->json('删除失败', null, 0);

    }

    protected function findModel($id)
    {
        if (($model = Memorial::findOne($id)) !== null) {

            if ($model->user_id != Yii::$app->user->id) {
                throw new yii\web\NotAcceptableHttpException('操作错误');
            }
            return $model;
        } else {
            throw new NotFoundHttpException('页面未找到.');
        }
    }
}
