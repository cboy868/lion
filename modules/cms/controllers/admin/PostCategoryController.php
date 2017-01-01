<?php

namespace app\modules\cms\controllers\admin;

use Yii;
use app\modules\cms\models\PostCategory;
use app\modules\cms\models\PostCategorySearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostCategoryController implements the CRUD actions for PostCategory model.
 */
class PostCategoryController extends BackController
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

        $tree = PostCategory::sortTree();
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

        $model = new PostCategory();

        if ($model->load(Yii::$app->request->post())) {

            // $upload = Up::getInstance($model, 'covert', 'foods_category');

            // if ($upload) {
            //     $upload->on(Up::EVENT_AFTER_UPLOAD, ['core\helpers\Image', 'thumb']);
            //     $upload->on(Up::EVENT_AFTER_UPLOAD, ['core\helpers\Image', 'water'], null, false);
            //     $upload->save();

            //     $info = $upload->getInfo();
            //     $model->cover = $info['path'] . '/' . $info['fileName'];
            // }

            if ($model->save()) {
                return $this->redirect(['index']);
            }
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
            $upload = Up::getInstance($model, 'covert', 'foods_category');

            if ($upload) {
                $upload->on(Up::EVENT_AFTER_UPLOAD, ['core\helpers\Image', 'thumb']);
                $upload->on(Up::EVENT_AFTER_UPLOAD, ['core\helpers\Image', 'water'], null, false);
                $upload->save();

                $info = $upload->getInfo();
                $model->cover = $info['path'] . '/' . $info['fileName'];
            }

            if ($model->save()) {
                return $this->redirect(['index']);
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

        return $this->redirect(['index']);
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
        if (($model = PostCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
