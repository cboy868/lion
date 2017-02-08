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

            $u = new UserForm;
            $u->email = $email;
            $u->username = substr($email, 0, strpos($email, '@'));
            $u->password = StringHelper::range(6);

            if ($u->create()) {

                $mailer = Yii::$app->mailer->compose('@app/core/views/mail/html');
                $mailer->setTo($email)->setSubject('某某某公司')->setHtmlBody($this->note($u->username, $u->password));
                if ($mailer->send()) {
                    return $this->json(null, '谢谢使用，您的邮箱提交成功,我们为您提供了一个本网站的登录账号，详细信息已发至您的邮箱', 1);
                };
            }

            return $this->json(null, '谢谢使用，您的邮箱提交成功', 1);
            
        } 
        $errors = $model->getErrors();
        return $this->json(null, $errors['email']['0'], 0);
    }

    public function note($username, $password)
    {
        $content = <<<EMAIL
        <p>您好，非常感谢您关注本公司产品，为方便您了解本公司产品信息，特为您提供本网站的登录账号，如半年内未登录，系统将会自动为您清除，请放心使用，具体信息如下:</p>
        网址:<a href="http://www.lion.cn" target="_blank">lion</a>;
        用户名:$username;
        密码:$password;
EMAIL;
        return $content;
    }

}
