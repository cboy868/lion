<?php

namespace app\modules\mod\controllers\admin;

use Yii;
use app\modules\mod\models\Module;
use app\modules\mod\models\ModuleSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\modules\mod\models\Field;
use app\modules\mod\models\FieldSearch;

/**
 * ModuleController implements the CRUD actions for Module model.
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
     * Lists all Module models.
     * @return mixed
     * @name 模块管理列表
     */
    public function actionIndex()
    {

        // $model = $this->findModel(11);
        // Module::createModels($model);

        $searchModel = new ModuleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        if (($model = Module::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }





    //-------------------------------------------- 字段管理部分 ---------------------------------------



    /**
     * @name 字段管理
     */
    public function actionField()
    {

        $searchModel = new FieldSearch();
        $queryParams = Yii::$app->request->queryParams;


        $id = Yii::$app->request->get('id');
        $modInfo = Module::findOne($id);

        $queryParams['FieldSearch']['table'] = $modInfo->module .'_'. $modInfo->mid;

        $dataProvider = $searchModel->search($queryParams);

        return $this->render('field', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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

        $model = new Field();

        if ($model->load(Yii::$app->request->post())) {

            $outerTransaction = Yii::$app->db->beginTransaction();
            try {
                $mod = Module::findOne($id);

                $model->table = $model->table .'_'. $mod->mid;
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

            // $id = Yii::$app->getRequest()->get('id');
            $modInfo = Module::findOne($id);

            $model->loadDefaultValues();
            return $this->render('create-field', [
                'model' => $model,
                'modInfo' => $modInfo,
            ]);
        }
    }

    /**
     * @name 修改字段
     */
    public function actionUpdateField()
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
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
