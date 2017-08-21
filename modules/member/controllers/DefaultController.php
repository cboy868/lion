<?php

namespace app\modules\member\controllers;

use yii;
use app\core\helpers\Url;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\modules\member\models\LoginForm;
use app\modules\cms\models\Favor;
use app\modules\user\models\Log;
use app\modules\user\models\Addition;
use app\modules\user\models\Log as LoginLog;
use app\modules\member\models\RegisterForm;
use app\modules\user\models\Token;

class DefaultController extends \app\core\web\MemberController
{

	public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
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

    public function actionReg()
    {
        $this->layout = "@app/core/views/layouts/single.php";
        $model = new RegisterForm();

        if ($model->load(Yii::$app->request->post()) && $user = $model->create()) {

            $outerTransaction = Yii::$app->db->beginTransaction();
            try {

                Addition::create($user);

                if ($token = Token::create($user, Token::TYPE_REGISTER)) {
                    $url = Url::toRoute(['/member/user/default/confirm', 'code'=>$token->code], true);
                    $mailer = Yii::$app->mailer->compose('@app/core/views/mail/html');
                    $mailer->setTo($user->email)->setSubject('某某某公司找回密码')->setHtmlBody($this->note($url));
                    if ($mailer->send()) {
                        Yii::$app->getSession()->setFlash('success', '已发送激活邮件到您的邮箱，请先激活');
                    } else {
                        throw new \Exception("邮件发送失败，请联系客服或重新注册", 1);
                    };

                }
                $outerTransaction->commit();

            } catch (\Exception $e) {
                echo $e->getMessage();
                $outerTransaction->rollBack();
            }

            return $this->redirect(['login']);
        } else {
            return $this->render('reg', [
                'model' => $model,
            ]);
        }

    }

    private function note($url)
    {
        $content = <<<EMAIL
        <p>您好，请点击以下连接找回密码,如果浏览器不跳转，可直接复制连接到浏览器:</p>
        <p><a href="$url">$url</a></p>
EMAIL;
        return $content;
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['/']);
    }

}
