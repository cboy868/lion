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
    public $layout = "@app/modules/member/views/layouts/member.php";

    public function init()
    {
        parent::init();
        \Yii::$app->homeUrl = \yii\helpers\Url::toRoute(['/']);
        $this->_theme();

    }

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

    public function actionIndex()
    {
        return $this->render('index');
    }


    protected function _theme() {
        $model = \app\modules\sys\models\Set::findOne('theme');

        $this->view->theme->pathMap = [
            '@app/modules/member/views/default' => '@app/web/theme/'.$model->svalue.'/member/default',
            '@app/modules/member/views/layouts' => '@app/web/theme/' . $model->svalue . '/member/layouts',

        ];
    }




}
