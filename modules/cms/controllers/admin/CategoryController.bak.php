<?php

namespace app\modules\cms\controllers\admin;

use Yii;
use app\modules\cms\models\Category;
use app\modules\cms\models\CategorySearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\core\base\Upload;

/**
 * PostCategoryController implements the CRUD actions for PostCategory model.
 */
class CategoryController extends BackController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all PostCategory models.
     * @return mixed
     */
    public function actionIndex()
    {

        $tree = Category::sortTree();
        return $this->render('index', [
            'cate' => $tree,
        ]);
    }

    /**
     * Displays a single PostCategory model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PostCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->getRequest();

        $model = new Category();
        $model->res_name = $request->get('res_name');
        if ($request->get('pid')) {
            $model->pid = $request->get('pid');
        }

        if (Yii::$app->request->isPost) {
            $model->load($request->post());
            $upload = Upload::getInstance($model, 'covert', 'cms_category');

            if ($upload) {
                $upload->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\helpers\Image', 'thumb']);
                $upload->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);
                $upload->save();

                $info = $upload->getInfo();

                $model->thumb = $info['mid'];
            }

            $model->save();

            $uri = $_SERVER["HTTP_REFERER"];

            return $this->redirect($uri);
        } 

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $upload = Upload::getInstance($model, 'covert', 'cms_category');

            if ($upload) {
                $upload->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\helpers\Image', 'thumb']);
                $upload->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);
                $upload->save();

                $info = $upload->getInfo();

                $model->thumb = $info['mid'];
            }

            if ($model->save()) {
                $uri = $_SERVER["HTTP_REFERER"];

                return $this->redirect($uri);
            }
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
        
    }

    /**
     * Deletes an existing PostCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect($_SERVER["HTTP_REFERER"]);
    }

    /**
     * Finds the PostCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PostCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
