<?php

namespace app\modules\sys\controllers\admin;

use Yii;
use app\modules\sys\models\AuthGroup;
use app\modules\sys\models\AuthGroupSearch;
use yii\web\NotFoundHttpException;
use app\core\helpers\Pinyin;
use app\modules\sys\rbac\Permission;
/**
 * AuthGroupController implements the CRUD actions for AuthGroup model.
 */
class AuthGroupController extends AuthController
{
    
    /**
     * @name 权限组列表
     * @menu true
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @name 化分权限
     * @menu false
     */
    public function actionPermission($id)
    {
        $model = $this->auth->getRole($id);

        return $this->render('permission', [
            'classes'   => Permission::getShowFormat($id), 
            'model' => $model
            ]);
    }

    /**
     * Displays a single AuthGroup model.
     * @param string $id
     * @return mixed
     */
    // public function actionView($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

    /**
     * @name 添加权限组
     * Creates a new AuthGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new AuthGroup();

        if ($model->load(Yii::$app->request->post()) ) {

            $model->name  = strtolower(Pinyin::pinyin($model->real_title)) .'_'. uniqid();

            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);

    }

    /**
     * @name 编辑权限组
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->name  = strtolower(Pinyin::pinyin($model->real_title)) .'_'. uniqid();

            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * @name 删除权限组
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

     /**
     * @name 添加删除权限
     */
    public function actionTogglePermission()
    {
        $request = Yii::$app->getRequest();

        $role_name = $request->post('role_name');
        $check = $request->post('check');
        $permissions = $request->post('permission');

        $role = $this->auth->getRole($role_name);
        $method = $check == 'true' ? 'addChild' : 'removeChild';

        foreach ($permissions as $v) {
            $permission = $this->auth->getPermission($v);
            $this->auth->$method($role, $permission);
        }

        return $this->json(null, null, 1);

    }

    /**
     * Finds the AuthGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthGroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
