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


    public function actions()
    {       
        return  [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'maxLength' => 6, //最大显示个数
                'minLength' => 4,//最少显示个数
                // 'height'=>92,//高度
                // 'width' => 200,  //宽度  
                'padding' => 5,//间距
                'fontFile' => '@app/web/static/font/maiandragd.ttf'
            ],  //默认的写法
            // 'captcha' => [
            //             'class' => 'yii\captcha\CaptchaAction',
            //             'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            //             'backColor'=>0xebf2fd,//背景颜色
            //             'maxLength' => 6, //最大显示个数
            //             'minLength' => 5,//最少显示个数
            //             'padding' => 5,//间距
            //             'height'=>42,//高度
            //             'width' => 100,  //宽度  
            //             'foreColor'=>0x345180,     //字体颜色
            //             'offset'=>1,        //设置字符偏移量 有效果
            //             //'controller'=>'login',        //拥有这个动作的controller
            //     ],
        ];
    }




    public function actionFavor()
    {

        $post = Yii::$app->request->post();

        $filter = [
            'res_name' => $post['res_name'],
            'res_id'   => $post['res_id'],
            'user_id' => Yii::$app->user->id 
        ];

        if (Favor::find()->where($filter)->one()) {
            return $this->json(null, '您已收藏成功', 0);
        }


        $favor = new Favor;

        if ($favor->load($post, '')) {
            $favor->user_id = Yii::$app->user->id;

            if ($favor->save()) {

                $count = Favor::getCountByRes($post['res_name'], $post['res_id']);

                return $this->json(['count'=>$count], '收藏成功', 1);
            }
        }

        return $this->json(null, '收藏失败,请稍后重试', 0);
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


        $total['favor'] = Favor::find()->where(['user_id'=>Yii::$app->user->id])->count();


        return $this->render('panel', [
                'log' => Log::getLast(),
                'addition' => Yii::$app->user->identity->addition,
                'user' => Yii::$app->user->identity,
                'total' => $total,
            ]);
    }


    public function actionReg()
    {
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

            } catch (Exception $e) {
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


    public function actionLogin()
    {

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            LoginLog::create();

            return $this->redirect(['/member']);
            // return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
