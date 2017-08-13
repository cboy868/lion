<?php
/**
 * Created by PhpStorm.
 * User: wansq
 * Date: 2017/5/10
 * Time: 13:08
 */
namespace app\modules\blog\controllers\member;

use app\core\helpers\ArrayHelper;
use app\modules\blog\models\Album;
use app\modules\blog\models\AlbumPhoto;
use yii;
use app\modules\blog\models\Blog;

class AlbumController extends \app\modules\member\controllers\DefaultController
{

    public function actions()
    {
        return [
            'ue-upload' => [
                'class' => 'app\core\widgets\Ueditor\UploadAction',
            ],
            'album-upload' => [
                'class' => 'app\core\web\AlbumUploadAction',
                'type' =>'blog_album',
            ]
        ];
    }

    public function actionIndex()
    {
        $this->layout = "@app/modules/member/views/layouts/profile.php";
        return $this->render('index');
    }

    public function actionView()
    {
        $this->layout = "@app/modules/member/views/layouts/profile.php";
        return $this->render('view');
    }


    /**
     * @return string
     * @name 添加blog
     */
    public function  actionCreate()
    {

        $model = new Album();
        $req = \Yii::$app->request;


        $req = Yii::$app->request;
        if ($req->isPost)
        {
            $title = $req->post('Album')['title'];
            $images = $req->post('mid');

            $album = Album::findOne($title);
            if (!$album) {
                if ($model->load($req->post())) {
                    $model->is_customer = Yii::$app->user->identity->isStaff() ? 0 : 1;
                    $model->created_by = Yii::$app->user->id;
                    $model->thumb = isset($images[0]) ? $images[0] :0;
                    $model->save();
                    $album = $model;
                }
            } else {

                if (!$album->thumb) {
                    $album->thumb = isset($images[0]) ? $images[0] :0;
                    $album->save();
                }
            }


            //更新照片
            if ($images) {
                Yii::$app->db->createCommand()
                    ->update(
                        AlbumPhoto::tableName(),
                        ['album_id'=>$album->id],
                        ['id'=>$images, 'album_id'=>0]
                    )->execute();
            }

            return $this->redirect(['/blog/member/album/index']);

        }

        //找到已有相册
        $albums = Album::find()->where(['status'=>Album::STATUS_NORMAL])
                                ->andWhere(['created_by'=>Yii::$app->user->id])
                                ->all();
        $albums = ArrayHelper::map($albums, 'id', 'title');

        $model->loadDefaultValues();
        return $this->render('create', ['model'=>$model, 'albums'=>$albums]);
    }

    /**
     * @name 修改blog
     */
    public function  actionUpdate($id)
    {
        $model = Blog::findOne($id);
        if (!$model) {
            return $this->error('不存在此博客');
        }

        $req = \Yii::$app->request;

        if ($model->load($req->post())) {
            $model->is_customer = Yii::$app->user->identity->isStaff() ? 0 : 1;
            $model->type = Blog::TYPE_TEXT;
//            $model->created_by = Yii::$app->user->id;

            if ($model->save()) {
                return $this->redirect(['/blog/member/default/view', 'id'=>$model->id]);
            }
        }

        return $this->render('update', ['model'=>$model]);
    }
}
