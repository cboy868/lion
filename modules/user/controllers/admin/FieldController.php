<?php

namespace app\modules\user\controllers\admin;

use Yii;
use app\modules\user\models\User;
use app\modules\user\models\Addition;
use app\modules\user\models\UserField;
use app\modules\user\models\UserFieldSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FieldController implements the CRUD actions for UserField model.
 */
class FieldController extends BackController
{


    /**
     * 字段的输入类型 
     */
    public  $fieldType = [
            'input' => 'varchar(255)',
            'textarea' => 'text',
            'fulltext' => 'text',
            'radio' => 'varchar(100)',
            'select' => 'varchar(100)',
            'checkbox' => 'varchar(100)',

        ];

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
     * Lists all UserField models.
     * @return mixed
     * @name 用户字段列表
     */
    public function actionIndex()
    {

        $searchModel = new UserFieldSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserField model.
     * @param integer $id
     * @return mixed
     * @name 用户字段详情
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserField model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 添加字段
     */
    public function actionCreate()
    {

        $fieldType = $this->fieldType;

        $model = new UserField();

        if ($model->load(Yii::$app->request->post())) {

            $outerTransaction = Yii::$app->db->beginTransaction();
            try {
                $model->save();
                $type = $fieldType[$model->html];
                $tableName = Addition::getTableSchema()->name;

                $sql = "alter table $tableName add $model->name " . $type;
                
                Yii::$app->db->createCommand($sql)->execute();

                $outerTransaction->commit();
            } catch (Exception $e) {
                echo $e->getMessage();
                $outerTransaction->rollBack();
            }
            return $this->redirect(['index']);
        } else {

            $model->loadDefaultValues();
            return $this->render('create', [
                'model' => $model,
            ]);
        }

    }

    /**
     * Updates an existing UserField model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @name 修改字段信息
     */
    public function actionUpdate($id)
    {

        $fieldType = $this->fieldType;

        $model = $this->findModel($id);
        $ori_name = $model->name;

        if ($model->load(Yii::$app->request->post())) {
            $outerTransaction = Yii::$app->db->beginTransaction();
            try {
                $model->save();
                $type = $fieldType[$model->html];
                $tableName = Addition::getTableSchema()->name;
                $sql = "ALTER TABLE " . $tableName . " change `" . $ori_name . "` `" . $model->name . "` " . $type . " null";

                Yii::$app->db->createCommand($sql)->execute();
                $outerTransaction->commit();
            } catch (Exception $e) {
                echo $e->getMessage();
                $outerTransaction->rollBack();
            }

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UserField model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除字段
     */
    public function actionDelete($id)
    {
        $outerTransaction = Yii::$app->db->beginTransaction();
        try {
            $model = $this->findModel($id);//->delete();
            $tableName = Addition::getTableSchema()->name;
            $sql = "ALTER TABLE `" . $tableName . "` DROP " . $model->name;
            Yii::$app->db->createCommand($sql)->execute();
            $model->delete();
            $outerTransaction->commit();
        } catch (Exception $e) {
            echo $e->getMessage();
            $outerTransaction->rollBack();
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the UserField model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserField the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserField::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
