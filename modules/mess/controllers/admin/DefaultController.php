<?php

namespace app\modules\mess\controllers\admin;

use app\modules\mess\models\MessFoodCategory;
use app\modules\mess\models\MessMenuCategory;
use app\modules\mess\models\MessSupplier;
use app\modules\mess\models\SearchMessFoodCategory;
use app\modules\mess\models\SearchMessMenuCategory;
use app\modules\mess\models\SearchMessSupplier;
use Yii;
use app\modules\mess\models\Mess;
use app\modules\mess\models\SearchMess;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Mess model.
 */
class DefaultController extends BackController
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
     * Lists all Mess models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchMess();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchSup = new SearchMessSupplier();
        $supProvider = $searchSup->search(Yii::$app->request->queryParams);

        $searchFoodCate = new SearchMessFoodCategory();
        $FoodCateProvider = $searchFoodCate->search(Yii::$app->request->queryParams);

        $searchMenuCate = new SearchMessMenuCategory();
        $MenuCateProvider = $searchMenuCate->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'supProvider' => $supProvider,
            'foodCateProvider' => $FoodCateProvider,
            'menuCateProvider' => $MenuCateProvider,
        ]);
    }

    /**
     * Displays a single Mess model.
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
     * Creates a new Mess model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Mess();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    public function actionCreateSupplier()
    {
        $model = new MessSupplier();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('supplier-create', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreateFood()
    {
        $model = new MessFoodCategory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('food-create', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreateMenu()
    {
        $model = new MessMenuCategory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('menu-create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Mess model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdateSupplier($id)
    {
        $model = $this->findSuppier($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('supplier-update', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdateFood($id)
    {
        $model = $this->findFoodCategory($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('food-update', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdateMenu($id)
    {
        $model = $this->findMenuCategory($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('menu-update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Mess model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteSupplier($id)
    {
        $this->findSuppier($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteMenu($id)
    {
        $this->findMenuCategory($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteFood($id)
    {
        $this->findFoodCategory($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Mess model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mess the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mess::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findSuppier($id)
    {
        if (($model = MessSupplier::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findFoodCategory($id)
    {
        if (($model = MessFoodCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findMenuCategory($id)
    {
        if (($model = MessMenuCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
