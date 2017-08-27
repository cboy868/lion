<?php

namespace app\modules\memorial\controllers\home;

use app\core\models\Comment;
use app\modules\blog\models\Album;
use app\modules\blog\models\Blog;
use app\modules\blog\models\AlbumSearch;
use app\modules\blog\models\BlogSearch;
use app\modules\grave\models\Dead;
use app\modules\memorial\models\Memorial;
use app\modules\memorial\models\MemorialSearch;
use app\modules\memorial\models\Pray;
use app\modules\memorial\models\Remote;
use yii;
use yii\web\NotFoundHttpException;


class SiteController extends Controller
{
    public $layout = '@app/modules/memorial/views/home/layout/site.php';
    public function actionIndex()
    {
        $memorials = Memorial::find()->where(['privacy'=>Memorial::PRIVACY_PUBLIC])
                                    ->andWhere(['status'=>Memorial::STATUS_ACTIVE])
                                    ->orderBy('id desc')
                                    ->limit(12)
                                    ->all();

        $remotes = Remote::find()->where(['privacy'=>Remote::PRIVACY_PUBLIC])
                                ->andWhere(['status'=>Remote::STATUS_NORMAL])
                                ->orderBy('id desc')
                                ->limit(10)
                                ->all();

        $albums = Album::find()->where(['privacy'=>Album::PRIVACY_PUBLIC])
                                ->andWhere(['status'=>Album::STATUS_NORMAL])
                                ->orderBy('id desc')
                                ->limit(5)
                                ->all();

        $msg = Comment::find()->where(['privacy'=>Comment::PRIVACY_PUBLIC, 'pid'=>0])
                            ->andWhere(['status'=>Comment::STATUS_NORMAL])
                            ->orderBy('id desc')
                            ->limit(15)
                            ->all();

        $blogs = Blog::find()->where(['privacy'=>Blog::PRIVACY_PUBLIC])
                            ->andWhere(['status'=>Blog::STATUS_NORMAL,'res'=>Blog::RES_MISS])
                            ->orderBy('id desc')
                            ->limit(15)
                            ->all();

        $birth = Dead::find()->where(['<>', 'memorial_id', 'null'])
                             ->andWhere(['status'=>Dead::STATUS_NORMAL])
                             ->andWhere(['like','birth',date("m-d")])
                             ->limit(9)
                             ->all();

        $fete = Dead::find()->where(['<>', 'memorial_id', 'null'])
                            ->andWhere(['status'=>Dead::STATUS_NORMAL])
                            ->andWhere(['like','fete',date("m-d")])
                            ->limit(9)
                            ->all();


        return $this->render('index',[
            'memorials' => $memorials,
            'remotes' => $remotes,
            'albums' => $albums,
            'msgs' => $msg,
            'blogs' => $blogs,
            'birth' => $birth,
            'fete' => $fete
        ]);
    }

    public function actionMemorial()
    {

        $searchModel = new MemorialSearch();
        $params = Yii::$app->request->queryParams;

        $dataProvider = $searchModel->search($params);

        return $this->render('memorial', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @name 照片
     */
    public function actionAlbum()
    {
        $params = Yii::$app->request->queryParams;

        $params['AlbumSearch']['privacy'] = Album::PRIVACY_PUBLIC;
        $params['AlbumSearch']['status'] = Album::STATUS_NORMAL;

        $searchModel = new AlbumSearch();
        $dataProvider = $searchModel->searchMemorial($params);

        return $this->render('album', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * @name 追思文章
     */
    public function actionMiss()
    {
        $params = Yii::$app->request->queryParams;

        $params['BlogSearch']['res'] = Blog::RES_MISS;
        $params['BlogSearch']['privacy'] = Blog::PRIVACY_PUBLIC;


        $searchModel = new BlogSearch();
        $dataProvider = $searchModel->homeSearch($params);

        return $this->render('miss', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @name 祝福
     * 1 留言
     * 2 送礼物
     * 3 远程祭祀
     */
    public function actionMsg()
    {
        //取评论
        $comments = Comment::getByRes('memorial',null, 15, '45x45');

        return $this->render('msg',[
            'comments' => $comments
        ]);
    }

    public function actionDays()
    {
        return $this->render('days');
    }

    /**
     * @name 祭祀记录
     */
    public function actionRecord()
    {
        return $this->render('record');
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
