<?php

namespace app\modules\memorial\controllers\home;

use app\core\models\Comment;
use app\modules\memorial\models\Memorial;
use app\modules\memorial\models\Pray;
use yii;

class SiteController extends Controller
{
    public $layout = '@app/modules/memorial/views/home/layout/site.php';
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @name 照片
     */
    public function actionAlbum()
    {
        return $this->render('album');
    }



    /**
     * @name 追思文章
     */
    public function actionMiss()
    {
        return $this->render('miss');
    }


    /**
     * @name 祝福
     */
    public function actionMsg()
    {
        return $this->render('msg');
    }

    /**
     * @name 祭祀记录
     */
    public function actionRecord()
    {
        return $this->render('record');
    }

}
