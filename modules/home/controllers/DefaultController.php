<?php
namespace app\modules\home\controllers;

use app\modules\home\models\MsgForm;
use Yii;

class DefaultController extends HomeController
{


	public function actionIndex()
	{
	    return $this->render('index');
	}

	public function actionAbout()
	{
		return $this->render('about');
	}

	/**
	 * @name 联系我们
	 */
	public function actionContact()
	{
	    $model = new MsgForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->create()) {
                Yii::$app->session->setFlash('success', '留言成功，非常感谢您的关注,我们会尽快联系您');
                return $this->redirect(['contact']);
            }
        }
		return $this->render('contact', ['model'=>$model]);
	}

	public function actionLogin()
	{
		return $this->render('login');
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
            ]
        ];
    }







}
