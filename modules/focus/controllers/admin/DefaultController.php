<?php

namespace app\modules\focus\controllers\admin;

use Yii;
use app\modules\focus\models\Focus;
use app\modules\focus\models\FocusSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\core\base\Upload;
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
        $searchModel = new FocusSearch();
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
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Focus model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 添加焦点图
     */
    public function actionCreate()
    {
        $model = new Focus();
        if ($model->load(Yii::$app->request->post())) {
             $upload = Upload::getInstance($model, 'image', 'focus');

            if ($upload) {
                $upload->save();
                $info = $upload->getInfo();
                $model->image = $info['path'] . '/' . $info['fileName'];
             }
             
             if ($model->save()) {
                return $this->redirect(['index']);
             }
        }
        return $this->renderAjax('create', [
            'model' => $model,
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
}
