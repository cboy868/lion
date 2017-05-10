<?php
/**
 * Created by PhpStorm.
 * User: wansq
 * Date: 2017/5/10
 * Time: 13:08
 */
namespace app\modules\blog\controllers\member;

use yii;
use app\modules\blog\models\Blog;

class DefaultController extends \app\modules\member\controllers\DefaultController
{

    public function actions()
    {
        return [
            'ue-upload' => [
                'class' => 'app\core\widgets\Ueditor\UploadAction',
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

        $model = new Blog();
        $req = \Yii::$app->request;
        if ($model->load($req->post())) {
            $model->is_customer = Yii::$app->user->identity->isStaff() ? 0 : 1;
            $model->type = Blog::TYPE_TEXT;
            $model->created_by = Yii::$app->user->id;

            if ($model->save()) {
                return $this->redirect(['/blog/home/default/view', 'id'=>$model->id]);
            }
        }

        $model->loadDefaultValues();
        return $this->render('create', ['model'=>$model]);
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
                return $this->redirect(['/blog/home/default/view', 'id'=>$model->id]);
            }
        }

        return $this->render('update', ['model'=>$model]);
    }
}
