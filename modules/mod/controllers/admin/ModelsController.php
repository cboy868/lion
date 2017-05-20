<?php

namespace app\modules\mod\controllers\admin;

use app\modules\mod\models\Module;
use Yii;
use app\modules\mod\models\Models;
use app\modules\mod\models\ModelsSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\modules\mod\models\Field;
use app\modules\mod\models\FieldSearch;

/**
 * ModuleController implements the CRUD actions for Module model.
 */
class ModelsController extends BackController
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
     * Lists all Module models.
     * @return mixed
     * @name 模块管理列表
     */
    public function actionIndex($mid)
    {

        // $model = $this->findModel(11);
        // Module::createModels($model);

        $searchModel = new ModelsSearch();
        $params = Yii::$app->request->queryParams;
        if (isset($params['mid'])) {
            $params['ModelsSearch']['mid'] = $params['mid'];
        }

        $module = Module::findOne($mid);

        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'module' => $module
        ]);
    }

    /**
     * Displays a single Module model.
     * @param integer $id
     * @return mixed
     * @name 模块详情
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Module model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 添加模块
     */
    public function actionCreate()
    {
        $model = new Module();

        if ($model->load(Yii::$app->request->post())) {

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->save();
                Module::createModels($model);
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
            return $this->redirect(['index']);
        } else {

            $mods =  Yii::$app->controller->module->params['mod'];
            $model->loadDefaultValues();
            return $this->render('create', [
                'model' => $model,
                'mods'  => $mods
            ]);
        }
    }

    /**
     * Updates an existing Module model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @name 修改模块
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            $mods =  Yii::$app->controller->module->params['mod'];
            return $this->render('update', [
                'model' => $model,
                'mods'  => $mods
            ]);
        }
    }

    /**
     * Deletes an existing Module model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $mod = $this->findModel($id);
        $model = $mod;
        $mod->delete();

        Module::deleteMod($model);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Module model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Module the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Models::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }





    //-------------------------------------------- 字段管理部分 ---------------------------------------



    /**
     * @name 字段管理
     */
    public function actionField($id)
    {

        $searchModel = new FieldSearch();
        $queryParams = Yii::$app->request->queryParams;

        $mInfo = Models::findOne($id);

        $queryParams['FieldSearch']['table'] = $mInfo->module;

        $dataProvider = $searchModel->search($queryParams);

        return $this->render('field', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'mInfo' => $mInfo
        ]);

    }

    /**
     * @name 添加字段
     */
    public function actionCreateField($id)
    {

        $fieldType = [
            'input' => 'varchar(255)',
            'textarea' => 'text',
            'fulltext' => 'text',
            'radio' => 'varchar(100)',
            'select' => 'varchar(100)',
            'checkbox' => 'varchar(100)',

        ];

        $mInfo = Models::findOne($id);

        $model = new Field();
        if ($model->load(Yii::$app->request->post())) {

            $outerTransaction = Yii::$app->db->beginTransaction();
            try {
                $model->save();

                $type = $fieldType[$model->html];

                $sql = "alter table $model->table add $model->name " . $type;

                Yii::$app->db->createCommand($sql)->execute();

                $outerTransaction->commit();
            } catch (Exception $e) {
                echo $e->getMessage();
                $outerTransaction->rollBack();
            }

            return $this->redirect(['field', 'id'=>$id]);
        } else {

            $model->loadDefaultValues();
            $model->model_id = $id;
            return $this->render('create-field', [
                'model' => $model,
                'mInfo' => $mInfo,
            ]);
        }
    }

    /**
     * @name 修改字段
     */
    public function actionUpdateField($id)
    {
        $model = $this->findFieldModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['field', 'id' => $model->model_id]);
        } else {
            return $this->render('update-field', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @name 字段详情
     */
    public function actionFieldView()
    {
        return $this->render('view', [
            'model' => $this->findFieldModel($id),
        ]);
    }

    protected function findFieldModel($id)
    {
        if (($model = Field::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @name 删除字段
     */
    public function actionDeleteField($id)
    {
        $this->findFieldModel($id)->delete();

        return $this->redirect(['index']);
    }

}
