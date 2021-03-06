<?php

namespace app\modules\admin\controllers;

use yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\modules\admin\models\LoginForm;
use app\modules\user\models\Log as LoginLog;
use app\modules\grave\models\search\TombSearch;

class DefaultController extends \app\core\web\BackController
{

	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'error', 'signup','logout', 'index'],
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

    public function actions()
    {
        return [
            'comment' => [
                'class' => 'app\core\widgets\comment\CommentAction',
            ],
            'ue-upload' => [
                'class' => 'app\core\widgets\Ueditor\UploadAction',
            ]
        ];
    }


    /**
     * @name 管理后台首页
     */
    public function actionIndex()
    {
        $searchModel = new TombSearch();
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->searchWork($params);

        LoginLog::getLast();

        return $this->render('work', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);



//        LoginLog::getLast();
//        return $this->render('index');
    }

    /**
     * @name 工作
     */
    public function actionWork()
    {
        $searchModel = new TombSearch();
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->searchWork($params);
        return $this->render('work', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }


    public function actionTombs()
    {
        $searchModel = new TombSearch();
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->searchWork($params);
        return $this->renderAjax('tombs', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * @name 工作台
     */
    public function actionWorkbench()
    {
        return $this->render('workbench');
    }


    public function actionLogin()
    {

        $this->layout = "@app/core/views/layouts/single.php";
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            LoginLog::create();
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['/']);
    }

    public function actionTest()
    {
        return $this->render('test');
    }

}
