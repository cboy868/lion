<?php

namespace app\modules\focus\controllers\admin;

use Yii;
use app\modules\focus\models\Focus;
use app\modules\focus\models\FocusSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\core\base\Upload;

use app\modules\focus\models\Category;
use app\modules\focus\models\CategorySearch;
/**
 * AdminController implements the CRUD actions for Focus model.
 */
class DefaultController extends BackController
{
    /**
     * Lists all Focus models.
     * @return mixed
     * @name 焦点图列表
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Focus model.
     * @param integer $id
     * @return mixed
     * @name 焦点图详情
     */
    public function actionList($id)
    {
        $searchModel = new FocusSearch();

        $params = Yii::$app->request->queryParams;
        $params['FocusSearch']['category_id'] = $params['id'];
        $dataProvider = $searchModel->search($params);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'category' => self::findCategoryModel($id)
        ]);
    }

    /**
     * Creates a new Focus model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 添加焦点图
     */
    public function actionCreate($category_id)
    {
        $category = Category::findOne($category_id);
        $model = new Focus();
        $model->category_id = $category_id;
        if ($model->load(Yii::$app->request->post())) {
             $upload = Upload::getInstance($model, 'image', 'focus');

            if ($upload) {
                $upload->save();
                $info = $upload->getInfo();
                $model->image = $info['path'] . '/' . $info['fileName'];
             }
             
             if ($model->save()) {

                $model->updateCategoryThumb();
                return $this->redirect(['list', 'id'=>$category_id]);
             }
        }
        $model->link = 'http://';
        return $this->renderAjax('create', [
            'model' => $model,
            'category' => $category
        ]);
    }

    /**
     * Updates an existing Focus model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @name 修改焦点图
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $upload = Upload::getInstance($model, 'image', 'focus');

            if ($upload) {
                $upload->save();
                $info = $upload->getInfo();
                $model->image = $info['path'] . '/' . $info['fileName'];
             } else{
                unset($model->image);
             }



            if ($model->save()) {
                $model->updateCategoryThumb();
                return $this->redirect(['list', 'id'=>$model->category_id]);
             }
        }
        return $this->renderAjax('update', [
            'model' => $model,
            'category' => Category::findOne($model->category_id)
        ]);
    }

    public function actionSort($id)
    {
        $ids = Yii::$app->request->post('ids');

        $connection = Yii::$app->db;

        foreach ($ids as $k => $v) {
            $connection->createCommand()
                          ->update(
                            Focus::tableName(), 
                            ['sort' => $k], 
                            ['id'=>$v])
                          ->execute();
        }

        return $this->json();
    }

    public function actionCover($category_id, $focus_id)
    {
        $model = $this->findModel($focus_id);

        $category = $this->findCategoryModel($category_id);
        $category->thumb = $model->image;
        $category->save();

        return $this->json();
    }

    /**
     * Deletes an existing Focus model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除焦点图
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Focus model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Focus the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Focus::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    //------------------------------ category -------------------------

     public function actionCreateCate()
    {

        $model = new Category();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create-cate', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @name 更新分类
     */
    public function actionUpdateCate($id)
    {

        $model = $this->findCategoryModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update-cate', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除
     */
    public function actionDeleteCate($id)
    {
        $this->findCategoryModel($id)->delete();

        $condition = 'category_id='.$id;
        Yii::$app->db->createCommand()->delete('{{%focus}}', $condition)->execute();

        return $this->redirect(['index']);
    }

    protected function findCategoryModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
