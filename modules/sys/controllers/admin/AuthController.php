<?php

namespace app\modules\sys\controllers\admin;

use yii;
use app\modules\sys\rbac\Permission;
use yii\filters\VerbFilter;

class AuthController extends \app\core\web\BackController
{

    public $auth;

    /**
     * @name 权限初始化
     */
    public function init()
    {
        $this->auth = Yii::$app->authManager;
    }

    public function behaviors()
    {
        // $behavior = parent::behaviors();
        // $access = $behavior['access'];
        return [
            // 'access' => $access,
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

}
