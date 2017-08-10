<?php

namespace app\modules\memorial\controllers\member;

use app\modules\blog\models\Blog;
use app\modules\blog\models\BlogSearch;
use app\modules\grave\models\Dead;
use yii;
use app\modules\memorial\models\Memorial;
use app\modules\memorial\models\MemorialSearch;
use app\core\base\Upload;
use yii\web\NotFoundHttpException;
use yii\base\Model;

class DefaultController extends \app\core\web\MemberController
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


            $upload = Upload::getInstance($model, 'thumb', 'memorial');

            if ($upload) {
                $upload->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\helpers\Image', 'thumb']);
                $upload->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);
                $upload->save();

                $info = $upload->getInfo();
                $model->thumb = $info['mid'];
            }

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
        $thumb = $model->thumb;

        if ($model->load(Yii::$app->request->post()) ) {


            $upload = Upload::getInstance($model, 'thumb', 'memorial');

            if ($upload) {
                $upload->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\helpers\Image', 'thumb']);
                $upload->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);
                $upload->save();

                $info = $upload->getInfo();
                $model->thumb = $info['mid'];
            } else {
                $model->thumb = $thumb;
            }

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

    public function actionArchive($id)
    {
        $memorial = $this->findModel($id);

        $params = Yii::$app->request->queryParams;

        $params['BlogSearch']['user_id'] = Yii::$app->user->id;
        $params['BlogSearch']['res'] = Blog::RES_ARCHIVE;
        $searchModel = new BlogSearch();
        $dataProvider = $searchModel->search($params);

        return $this->render('archive', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $memorial
        ]);

    }

    public function actionCreateArchive($id)
    {

        $model = new Blog();

        $req = Yii::$app->getRequest();

        if (Yii::$app->request->isPost) {
            $model->load($req->post());
            $model->memorial_id = $id;
            $model->res = Blog::RES_ARCHIVE;
            $model->created_by = Yii::$app->user->id;
            $model->is_customer = Yii::$app->user->identity->isStaff() ? 0 : 1;
            $model->ip = Yii::$app->request->getUserIP();
            $model->status = Blog::STATUS_VRIFY;

            if ($model->save() !== false) {
                Yii::$app->session->setFlash('success', '添加档案成功');
            } else {
                Yii::$app->session->setFlash('error', '添加档案失败,请重试或联系管理员');
            }

            return $this->redirect(['archive', 'id'=>$id]);
        }


        $model->privacy = Blog::PRIVACY_PUBLIC;
        return $this->renderAjax('create-archive', [
            'model' => $model,
        ]);
    }

    public function actionUpdateArchive($archive_id)
    {

        $model = Blog::findOne($archive_id);

        $req = Yii::$app->getRequest();

        if (Yii::$app->request->isPost) {
            $model->load($req->post());
            $model->ip = Yii::$app->request->getUserIP();
            $model->status = Blog::STATUS_VRIFY;

            if ($model->save() !== false) {
                Yii::$app->session->setFlash('success', '修改档案成功');
            } else {
                Yii::$app->session->setFlash('error', '修改档案失败,请重试或联系管理员');
            }

            return $this->redirect(['archive', 'id'=>$model->memorial_id]);
        }


        return $this->renderAjax('update-archive', [
            'model' => $model,
        ]);
    }

    public function actionViewArchive($archive_id)
    {

        $model = Blog::findOne($archive_id);

        return $this->renderAjax('view-archive', [
            'model' => $model,
        ]);
    }

    public function actionDelArchive($archive_id)
    {
        $model = Blog::findOne($archive_id);
        $model->delete();

        return $this->redirect(['archive', 'id'=>$model->memorial_id]);
    }

    /**
     * @name 追忆文章
     */
    public function actionMiss($id)
    {
        $memorial = $this->findModel($id);
        return $this->render('miss',[
            'model' => $memorial
        ]);
    }

    public function actionCreateMiss($id)
    {

    }

    public function actionAlbum($id)
    {
        $memorial = $this->findModel($id);
        return $this->render('album',[
            'model' => $memorial
        ]);
    }
    public function actionPhotos($id, $album_id)
    {
        $memorial = $this->findModel($id);
        return $this->render('photos',[
            'model' => $memorial
        ]);
    }

    public function actionMsg($id)
    {
        $memorial = $this->findModel($id);
        return $this->render('msg',[
            'model' => $memorial
        ]);
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
