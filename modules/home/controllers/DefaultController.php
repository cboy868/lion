<?php

namespace app\modules\home\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\core\helpers\StringHelper;

use app\modules\home\models\LoginForm;
use app\modules\cms\models\EmailForm;
use app\modules\home\models\UserForm;
use app\modules\user\models\User;

class DefaultController extends \app\core\web\HomeController
{

    public $layout = 'home.php';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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

    // /**
    //  * @inheritdoc
    //  */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'thumb' => [
                'class' => 'app\core\web\ThumbAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    // /**
    //  * Login action.
    //  *
    //  * @return string
    //  */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }


    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionEmail()
    {

        $email = Yii::$app->getRequest()->post('email');

        $model = new EmailForm;

        if ($model->contact($email)) {

            // $u = new UserForm;
            // $u->email = $email;
            // $u->username = substr($email, 0, strpos($email, '@'));
            // $u->password = StringHelper::range(6);

            // if ($u->create()) {
                // $pname = isset(Yii::$app->params['cp_name']) ? Yii::$app->params['cp_name'] : '';


                // $mailer = Yii::$app->mailer
                //                     ->compose('contact', ['username'=>$u->username,'password'=>$u->password])
                //                     ->setTo($email)
                //                     ->setSubject($pname);

                // if ($mailer->send()) {
                //     return $this->json(null, '谢谢使用，您的邮箱提交成功,我们为您提供了一个本网站的登录账号，详细信息已发至您的邮箱', 1);
                // };
            // }

            return $this->json(null, '谢谢使用，您的邮箱提交成功', 1);
            
        } 
        $errors = $model->getErrors();
        return $this->json(null, $errors['email']['0'], 0);
    }
}
