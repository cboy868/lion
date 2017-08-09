<?php

namespace app\modules\memorial\controllers\home;

use app\core\models\Comment;
use app\modules\cms\controllers\home\CommonController;
use app\modules\memorial\models\Pray;
use yii;
use app\modules\memorial\models\Memorial;
use yii\web\NotFoundHttpException;

class HallController extends Controller
{

    public function actionIndex($id)
    {
        $memorial = $this->findModel($id);
        $deads = $memorial->deads;

        return $this->render('index',[
            'memorial' => $memorial,
            'deads' => $deads
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

    protected function findModel($id)
    {
        if (($model = Memorial::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



}
