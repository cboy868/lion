<?php

namespace app\modules\sys\controllers\admin;

use yii;
use app\modules\sys\models\AuthPermission;
use app\modules\sys\rbac\Permission;

/**
 * @name 权限项
 */
class AuthPermissionController extends AuthController
{

	/**
	 * @name 权限主页面
     * 这个页面应该显示些啥东西，应该是些介绍，教程之类的东西
     * 所有权限项列表，可在此表修改权限项注释
	 */
    public function actionIndex()
    {
        return $this->render('index', ['classes'=>Permission::getShowFormat()]);
    }

    /**
     * @name 权限项入库
     * 第二次时，应该查数据库中是否存在此项，
     * 如果存在，则直接更新部分字段
     */
    public function actionSync()
    {

        if (Permission::sync()) {
            return $this->json(null, null, 1);
        } else {
            return $this->json(null, '初始化权限失败');
        }
    }

    public function actionTitle()
    {
        $request = Yii::$app->getRequest();
        $model = AuthPermission::find()->where(['name'=>$request->post('name')])->one();

        $model->real_title = $request->post('title');
        if ($model->save()) {
            return $this->json();
        } else {
            return $this->json(0);
        }
    }
}
