<?php

namespace app\modules\memorial\controllers\home;

use app\core\helpers\ArrayHelper;
use app\core\helpers\Url;
use app\core\models\Comment;
use app\modules\blog\models\Album;
use app\modules\blog\models\AlbumPhoto;
use app\modules\blog\models\AlbumPhotoSearch;
use app\modules\blog\models\AlbumSearch;
use app\modules\blog\models\Blog;
use app\modules\cms\controllers\home\CommonController;
use app\modules\grave\models\Order;
use app\modules\grave\models\Tomb;
use app\modules\memorial\models\OrderForm;
use app\modules\memorial\models\Pray;
use app\modules\memorial\models\Remote;
use app\modules\memorial\models\RemoteSearch;
use app\modules\order\models\Pay;
use app\modules\shop\models\Category;
use app\modules\shop\models\Goods;
use app\modules\shop\models\Sku;
use app\modules\user\models\Track;
use app\modules\wechat\models\User;
use EasyWeChat\Payment\Payment;
use yii;
use app\modules\memorial\models\Memorial;
use yii\web\NotFoundHttpException;
use app\modules\blog\models\BlogSearch;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Payment\Order as WechatOrder;
use yii\web\NotAcceptableHttpException;
use Endroid\QrCode\QrCode;
class HallController extends Controller
{
    public function actions()
    {
        return [
            'pl-upload' => [
                'class' => 'app\core\web\PluploadAction',
            ],
            'ue-upload' => [
                'class' => 'app\core\widgets\Ueditor\UploadAction',
            ]
        ];
    }

    public function beforeAction($action) {

        $currentaction = $action->id;
        $novalidactions = ['order','notify'];

        if(in_array($currentaction,$novalidactions)) {
            $action->controller->enableCsrfValidation = false;
        }

        if (Yii::$app->request->get('id')) {
            $memorial = $this->findModel(Yii::$app->request->get('id'));

            if ($memorial->privacy == Memorial::PRIVACY_PRIVATE && $memorial->user_id != Yii::$app->user->id) {
                throw new NotAcceptableHttpException('此馆非公开，您无权查看');
            }
        }

        parent::beforeAction($action);
        return true;
    }

    public function actionIndex($id)
    {
        $memorial = $this->findModel($id);
        $deads = $memorial->deads;

        //档案及追忆
        //档案
        $archives = Blog::find()->where([
            'memorial_id'=>$id,
            'status'=>Blog::STATUS_NORMAL,
            'privacy' => Blog::PRIVACY_PUBLIC,
            'res' =>Blog::RES_ARCHIVE
        ])
            ->orderBy('id desc')->limit(10)->all();

        //追忆
        $miss = Blog::find()->where([
            'memorial_id'=>$id,
            'status'=>Blog::STATUS_NORMAL,
            'privacy' => Blog::PRIVACY_PUBLIC,
            'res' =>Blog::RES_MISS
        ])
            ->orderBy('id desc')->limit(10)->all();


        //祝福
        $msgs = Comment::find()->where(['res_name'=>'memorial', 'res_id'=>$id, 'pid'=>0])
            ->orderBy('id desc')
            ->limit(10)->all();


        $memorial->track();

        return $this->render('index',[
            'memorial' => $memorial,
            'deads' => $deads,
            'archives' => $archives,
            'miss' => $miss,
            'msgs' => $msgs
        ]);
    }


    public function actionMemorial($id)
    {
        $memorial = $this->findModel($id);
        $memorial->track();

        $tracks = Track::find()->where(['res_name'=>Track::RES_MEMORIAL, 'res_id'=>$id])
            ->orderBy('id desc')
            ->limit(20)
            ->all();


        $albums = Album::find()->where(['memorial_id'=>$id,'privacy'=>Album::PRIVACY_PUBLIC])
            ->orderBy('id desc')->limit(10)->all();
        $albums_ids = ArrayHelper::getColumn($albums, 'id');
        $photos = AlbumPhoto::find()->where(['album_id'=>$albums_ids, 'status'=>AlbumPhoto::STATUS_ACTIVE])
            ->limit(10)->all();


        $miss = Blog::find()->where(['res'=>Blog::RES_MISS, 'memorial_id'=>$id])
            ->orderBy('id desc')
            ->limit(8)
            ->all();

        //祝福
        $msgs = Comment::find()->where(['res_name'=>'memorial', 'res_id'=>$id, 'pid'=>0])
            ->orderBy('id desc')
            ->limit(10)->all();

        //点烛献花
        $prays = Pray::find()->where(['memorial_id'=>$id])->orderBy('id desc')
            ->limit(10)
            ->all();

        $remotes = Remote::find()->where(['memorial_id'=>$id])
                                 ->orderBy('id desc')
                                ->limit(10)
                                ->all();

        return $this->render('memorial', [
            'memorial'=>$memorial,
            'tracks' => $tracks,
            'photos' => $photos,
            'miss' => $miss,
            'msgs' => $msgs,
            'prays' => $prays,
            'comment' => new Comment(),
            'remotes' => $remotes
        ]);
    }

    /**
     * @name 生平
     * @return string
     */
    public function actionLife($id)
    {

        $memorial = $this->findModel($id);
        $memorial->track();
        $deads = $memorial->deads;
        return $this->render('life', [
            'deads' => $deads,
            'memorial' => $memorial
        ]);
    }

    /**
     * @音容笑貌
     */
    public function actionAlbum($id)
    {
        $params = Yii::$app->request->queryParams;

        $params['AlbumSearch']['memorial_id'] = $id;
        $params['AlbumSearch']['privacy'] = Album::PRIVACY_PUBLIC;

        $searchModel = new AlbumSearch();
        $dataProvider = $searchModel->searchHome($params);

        $memorial = $this->findModel($id);
        $memorial->track();

        return $this->render('album', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    public function actionPhotos($album_id)
    {
        $album = Album::findOne($album_id);
        $album->track();

        $params = Yii::$app->request->queryParams;

        $params['AlbumPhotoSearch']['album_id'] = $album_id;
        $searchModel = new AlbumPhotoSearch();
        $dataProvider = $searchModel->searchHome($params);

        return $this->render('photos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'album' => $album,
        ]);

    }

    /**
     * @name 档案资料
     */
    public function actionArchive($id)
    {
        $memorial = $this->findModel($id);
        $memorial->track();

        $params = Yii::$app->request->queryParams;

        $params['BlogSearch']['res'] = Blog::RES_ARCHIVE;
        $params['BlogSearch']['memorial_id'] = $id;
        $params['BlogSearch']['privacy'] = Blog::PRIVACY_PUBLIC;

        $searchModel = new BlogSearch();
        $dataProvider = $searchModel->homeSearch($params);

        return $this->render('archive', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $memorial
        ]);
    }

    public function actionArchiveView($bid, $id)
    {
        $model = Blog::findOne($bid);

        if ($model->privacy == Blog::PRIVACY_PRIVATE) {
            throw new NotAcceptableHttpException('此文章非公开，您无权查看');
        }

        $model->track(Track::RES_ARCHIVE);

        return $this->render('archive-view',[
            'model' => $model
        ]);
    }

    public function actionMissView($bid, $id)
    {
        $model = Blog::findOne($bid);
        $model->track(Track::RES_MISS);

        if ($model->privacy == Blog::PRIVACY_PRIVATE) {
            throw new NotAcceptableHttpException('此文章非公开，您无权查看');
        }

        return $this->render('miss-view',[
            'model' => $model
        ]);
    }

    /**
     * @name 生前作品
     */
    public function actionWorks()
    {
        return $this->render('works');
    }

    /**
     * @name 追思文章
     */
    public function actionMiss($id)
    {
        $memorial = $this->findModel($id);
        $memorial->track();

        $params = Yii::$app->request->queryParams;

        $params['BlogSearch']['res'] = Blog::RES_MISS;
        $params['BlogSearch']['memorial_id'] = $id;
        $params['BlogSearch']['privacy'] = Blog::PRIVACY_PUBLIC;

        $searchModel = new BlogSearch();
        $dataProvider = $searchModel->homeSearch($params);

        return $this->render('miss', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $memorial
        ]);
    }


    /**
     * @name 微纪念
     */
    public function actionMsg($id)
    {
        $memorial = $this->findModel($id);
        $comment = new Comment();

        //取评论
        $comments = Comment::getByRes('memorial', $id, 15, '45x45');

        $memorial->track();
        return $this->render('msg',[
//            'model' => $memorial,
            'comment' => $comment,
            'comments' => $comments
        ]);
    }

    public function actionReplyMsg()
    {
        if (Yii::$app->user->isGuest) {
            return $this->json(null, '请先登录', 0);
        }

        $post = Yii::$app->request->post();


        $data = [
            'from' => Yii::$app->user->id,
            'to' => $post['to'],
            'content' => $post['content'],
            'pid' => $post['pid'],
            'res_name' => $post['res_name'],
            'res_id' => $post['res_id'],
            'privacy' => Comment::PRIVACY_PUBLIC
        ];

        $msg = new Comment();
        $msg->load($data, '');
        if ($msg->save() !== false) {
            return $this->json();
        }

        return $this->json(null, '回复失败',0);

    }

    public function actionCreateMsg()
    {
        $model = new Comment();
        $req = Yii::$app->getRequest();


        $model->load($req->post());

        $model->from = Yii::$app->user->id;
        $model->to = 0;
        $model->privacy = Comment::PRIVACY_PUBLIC;

        if ($model->save() !== false) {
            return $this->json();
        } else {
            return $this->json(null, '祝福留言失败,请重试或联系管理员', 0);
        }
    }

    public function actionCandleFlower($id)
    {
        $model = new Pray();
        $model->memorial_id = $id;

        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;

            if ($model->save() !== false) {
                return $this->json();
            } else {
                return $this->json(null, '祝福提交失败', 0);
            }
        }

        $types = $this->module->params['memorial_types'];

        return $this->renderAjax('candle-flower',[
            'model' => $model,
            'types' => $types
        ]);
    }

    public function actionRemote($id)
    {
        $goods = Goods::find()->where(['status'=>Goods::STATUS_ACTIVE,'can_remote'=>1])->all();
        $cids = ArrayHelper::getColumn($goods, 'category_id');
        $cates = Category::find()->where(['id'=>$cids])->all();
        $goods = ArrayHelper::index($goods, 'id', 'category_id');

        return $this->renderAjax('remote',[
            'goods' => $goods,
            'cates' => $cates,
            'memorial_id' => $id
        ]);
    }

    /**
     * @name 设置购买参数
     */
    public function actionSet($id, $gid)
    {
        $goods = Goods::findOne($gid);
        $set = new OrderForm();
        $set->use_time = date('Y-m-d', strtotime('+1 day'));
        $memorial = $this->findModel($id);
        return $this->renderAjax('set',[
            'goods' => $goods,
            'model' => $set,
            'memorial' => $memorial,
            'memorial_id' => $id
        ]);
    }

    public function actionRecord($id)
    {

        $params = Yii::$app->request->queryParams;

        $params['RemoteSearch']['memorial_id']=$id;

        $searchModel = new RemoteSearch();
        $dataProvider = $searchModel->search($params);

        return $this->render('record', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $remote_id
     * @name 祭祀视频
     */
    public function actionVideo($remote_id)
    {
        $model = Remote::findOne($remote_id);
        return $this->renderAjax('video', ['model'=>$model]);
    }

    protected function findModel($id)
    {
        if (($model = Memorial::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }




}
