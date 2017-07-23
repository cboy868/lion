<?php

namespace app\modules\memorial\controllers\home;

use app\core\models\Comment;
use app\modules\cms\controllers\home\CommonController;
use app\modules\memorial\models\Memorial;
use app\modules\memorial\models\Pray;
use yii;

class SiteController extends Controller
{

//    public function actions()
//    {
//        return [
//            'ue-upload' => [
//                'class' => 'app\core\widgets\Ueditor\UploadAction',
//            ]
//        ];
//    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @name 生平
     * @return string
     */
    public function actionLife()
    {
        return $this->render('life');
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
    public function actionAchive()
    {
        return $this->render('achive');
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
    public function actionMiss()
    {
        return $this->render('miss');
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



}
