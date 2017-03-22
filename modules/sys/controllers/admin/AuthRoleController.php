<?php

namespace app\modules\sys\controllers\admin;

use Yii;
use app\modules\sys\models\AuthRole;
use app\modules\sys\models\AuthRoleSearch;
use yii\web\NotFoundHttpException;
use app\core\helpers\Pinyin;
use app\modules\user\models\User;
use app\modules\sys\models\AuthGroup;
use yii\helpers\ArrayHelper;
/**
 * RoleController implements the CRUD actions for AuthRole model.
 */
class AuthRoleController extends AuthController
{
    /**
     * @name 角色列表
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthRoleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @name 角色用户分配列表
     */
    public function actionUser($id)
    {

        $auth = Yii::$app->authManager;
        $users = User::find()->where(['status' => 10, 'is_staff'=>User::STAFF_YES])
                             // ->andWhere('id>1')
                             ->orderBy('username')
                             ->all();

        $item = \app\modules\sys\models\AuthItem::findOne($id);

        $users_info = [];
        foreach ($users as $k => $v) {
            $pin = strtoupper(substr(Pinyin::pinyin($v['username']), 0, 1));
            $users_info[$pin][$v['id']] = [
                'username' => $v['username'],
                'pinyin' => Pinyin::pinyin($v['username']),
                'is_sel' => $auth->getAssignment($id, $v['id']) ? 1 : 0
            ];
        }

        $keys = array_keys($users_info);
        return $this->render('user', ['user'=>$users_info, 'keys'=>$keys, 'role_name'=>$id, 'item'=>$item]);
    }

    /**
     * @name 角色分配
     */
    public function actionToggleUser()
    {
        $request = Yii::$app->request;

        $role_name = $request->post('role', '');
        $user_ids = $request->post('user_id', '');
        $del = $request->post('is_sel');

        $method = $del == 'false' ? 'revoke' : 'assign';
        $role = $this->auth->getRole($role_name);

        foreach ($user_ids as $k => $v) {
            $this->auth->$method($role, $v);
        }

        return $this->json(null, '角色分配成功', 1);
    }


    /**
     * @name 角色分配权限组
     */
    public function actionPermission($id)
    {

        $role = $this->auth->getRole($id);

        $filter = ['type'=>AuthGroup::TYPE_ROLE,'level'=>AuthGroup::LEVEL_PERMISSION_GROUP];
        $permissionGroup = AuthGroup::find()->where($filter)
                                        ->orderBy('real_title asc')
                                        ->asArray()
                                        ->all();


        $childs = $this->auth->getChildren($role->name, AuthGroup::TYPE_ROLE, AuthGroup::LEVEL_PERMISSION_GROUP);
        $childrenNames = ArrayHelper::getColumn($childs, 'name');


        foreach ($permissionGroup as $k => &$v) {
            $v['is_sel'] = in_array($v['name'], $childrenNames) ? 1 : 0;
        }unset($v);

        return $this->render('permission',[
                'permission' => $permissionGroup,
                'role' => $role
            ]);
    }

    /**
     * @name 添加删除权限
     */
    public function actionTogglePermission()
    {

        $request = Yii::$app->getRequest();

        $role_name = $request->post('role_name');
        $is_sel = $request->post('is_sel');
        $permission_group = $request->post('permission_group');


        $role = $this->auth->getRole($role_name);
        $group = $this->auth->getRole($permission_group);

        $method = $is_sel == 'true' ? 'addChild' : 'removeChild';

        if ($this->auth->$method($role, $group)) {
            return $this->json(null, null, 1);
        } 

        return $this->json(null, '分配权限失败, 请稍后重试', 0);
        
    }



    /**
     * Displays a single AuthRole model.
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
     * @name 创建角色
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = '@backend/views/layouts/form';
        $model = new AuthRole();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @name 修改角色
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
        
    }

    /**
     * @name 删除角色
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
     * Finds the AuthRole model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthRole the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthRole::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
