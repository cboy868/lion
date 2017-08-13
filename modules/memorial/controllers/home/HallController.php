<?php

namespace app\modules\memorial\controllers\home;

use app\core\helpers\ArrayHelper;
use app\core\models\Comment;
use app\modules\blog\models\Album;
use app\modules\blog\models\AlbumPhoto;
use app\modules\blog\models\Blog;
use app\modules\cms\controllers\home\CommonController;
use app\modules\memorial\models\Pray;
use yii;
use app\modules\memorial\models\Memorial;
use yii\web\NotFoundHttpException;
use app\modules\blog\models\BlogSearch;

class HallController extends Controller
{

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

        //找几张照片
        $albums = Album::find()->where(['memorial_id'=>$id,'privacy'=>Album::PRIVACY_PUBLIC])
            ->orderBy('id desc')->limit(10)->all();
        $albums_ids = ArrayHelper::getColumn($albums, 'id');
        $photos = AlbumPhoto::find()->where(['album_id'=>$albums_ids, 'status'=>AlbumPhoto::STATUS_ACTIVE])
            ->limit(10)->all();

        return $this->render('index',[
            'memorial' => $memorial,
            'deads' => $deads,
            'archives' => $archives,
            'miss' => $miss,
            'msgs' => $msgs,
            'photos' => $photos
        ]);
    }

    public function actionMemorial($id)
    {
        $memorial = $this->findModel($id);
        return $this->render('memorial', ['memorial'=>$memorial]);
    }

    /**
     * @name 生平
     * @return string
     */
    public function actionLife($id)
    {

        $memorial = $this->findModel($id);
        $deads = $memorial->deads;
        return $this->render('life', [
            'deads' => $deads,
            'memorial' => $memorial
        ]);
    }

    /**
     * @音容笑貌
     */
    public function actionAlbum()
    {
        return $this->render('album');
    }

    /**
     * @name 档案资料
     */
    public function actionArchive($id)
    {
        $memorial = $this->findModel($id);

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
    public function actionMsg()
    {
        return $this->render('msg');
    }

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
