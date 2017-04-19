<?php

namespace app\modules\cms\controllers\home;

use yii;
use app\modules\cms\models\Album;
use app\modules\cms\models\AlbumImage;

class AlbumController extends \app\core\web\HomeController
{
    public function actionIndex($dir, $cid)
    {
    	$data = Album::albumList($dir, $cid);
        return $this->render('index', $data);
    }

    public function actionPhotos($dir, $album_id)
    {
    	$data = Album::photoList($dir, $album_id);

		return $this->render('photos', $data);
    }

    public function actionPhoto($id)
    {
    	$model = AlbumImage::findOne($id);
    	$pre = AlbumImage::find()->where(['album_id'=>$model->album_id, 'status'=>AlbumImage::STATUS_NORMAL])
    							 ->andWhere(['<', 'sort', $model->sort])
    							 ->one();
    	$next = AlbumImage::find()->where(['album_id'=>$model->album_id, 'status'=>AlbumImage::STATUS_NORMAL])
    							 ->andWhere(['>', 'sort', $model->sort])
    							 ->one();

    	return $this->render('photo', ['model'=>$model, 'pre'=>$pre, 'next'=>$next]);		 
    }
}
