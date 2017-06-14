<?php

namespace app\modules\shop\controllers\admin;

use Yii;
use app\modules\shop\models\Category;
use app\modules\shop\models\search\Category as CategorySearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\core\models\Attachment;

use app\core\base\Upload;

/**
 * CategoryController implements the CRUD actions for Category model.
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
     * Lists all Category models.
     * @return mixed
     * @name 分类列表
     */
    public function actionIndex()
    {

        // $tree = Category::sortTree();
        $records = Category::find()->asArray()->orderBy('sort desc')->all();

        foreach ($records as &$v) {
            $v['cover'] = Category::getThumb($v['thumb'], '36x36');
        }unset($v);

        $tree = Category::makeTree($records);

        return $this->render('index', [
            'cate' => $tree,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     * @name 分类详情
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 添加分类
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($model->load(Yii::$app->request->post())) {

            $up = Upload::getInstance($model, 'thumb', 'shop_category');
            if ($up) {
                $up->save();
                $info = $up->getInfo();
                $model->thumb = $info['mid'];
            }
            if (!$model->sort) {
                $model->sort = 0;
            }

             $model->save();
            return $this->redirect(['index']);
        } else {
            $model->loadDefaultValues();
            $model->sort = 0;
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @name 修改分类
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $thumb = $model->thumb;

        if ($model->load(Yii::$app->request->post())) {

            $up = Upload::getInstance($model, 'thumb', 'shop_category');
            if ($up) {
                $up->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);
                $up->save();
                $info = $up->getInfo();

                $model->thumb = $info['mid'];
            } else {
                $model->thumb = $thumb;
            }

            $model->save();

            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除分类
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
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
