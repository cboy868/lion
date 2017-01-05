<?php

namespace app\modules\member\controllers;

use yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\modules\member\models\LoginForm;

class DefaultController extends \app\core\web\MemberController
{

	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'error', 'signup', 'logout', 'index'],
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'signup'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @name 管理后台首页
     */
    public function actionIndex()
    {
        $this->layout = false;
        return $this->render('index');
    }

    public function actionPanel()
    {
        return $this->render('panel');
    }


    public function actionLogin()
    {


        return $this->render('login');

        // $this->layout = "@app/core/views/layouts/single.php";
        // if (!\Yii::$app->user->isGuest) {
        //     return $this->goHome();
        // }

        // $model = new LoginForm();
        // if ($model->load(Yii::$app->request->post()) && $model->login()) {
        //     return $this->goBack();
        // } else {
        //     return $this->render('login', [
        //         'model' => $model,
        //     ]);
        // }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
