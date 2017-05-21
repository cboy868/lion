<?php

namespace app\core\web;


use yii;
use yii\helpers\Url;

/**
 * Default controller for the `wechat` module
 */
class MemberController extends \app\core\web\Controller
{

//    public $layout = "@app/core/views/layouts/member.php";
    public $layout = "@app/modules/member/views/layouts/member.php";



    public function init()
    {

        parent::init();

        // Yii::$app->language = 'en-US';

        Yii::$app->user->loginUrl = ['member/default/login'];
        Yii::$app->errorHandler->errorAction = 'member/default/error';
//        \Yii::$app->homeUrl = \yii\helpers\Url::toRoute(['/']);
        $this->_theme();

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

    public function beforeAction($action)
    {
        Yii::$app->setHomeUrl(Url::toRoute(['/member/default/panel']));
        //检查不需要登录的action 如 site/login site/captcha
        if (in_array($action->uniqueID, $this->ignoreLogin()))
        {
            return parent::beforeAction($action);
        }

        if (\Yii::$app->user->isGuest) {
        	Yii::$app->user->loginRequired();
        	return false;
        }
       
        return parent::beforeAction($action);
    }

    /**
     * @name 不需要登录的动作
     */
    public function ignoreLogin()
    {
    	return [
            'member/default/login',
            'member/default/captcha', 
            'user/member/default/forget',
            'user/member/default/token',
            'user/member/default/confirm',
            'member/user/default/forget',
            'member/user/default/token',
            'member/user/default/confirm',
            'member/default/error',
            'member/default/reg'
    	];
    }

    protected function _theme() {
        $model = \app\modules\sys\models\Set::findOne('theme');

        $this->view->theme->pathMap = [
            '@app/modules/member/views/default' => '@app/web/theme/'.$model->svalue.'/member/default',
            '@app/modules/member/views/layouts' => '@app/web/theme/' . $model->svalue . '/member/layouts',
            '@app/modules/blog/views/member/default' => '@app/web/theme/' . $model->svalue . '/member/blog',
            '@app/modules/blog/views/member/album' => '@app/web/theme/' . $model->svalue . '/member/album',
            '@app/modules/blog/views/member/video' => '@app/web/theme/' . $model->svalue . '/member/video',
            '@app/modules/order/views/member/default' => '@app/web/theme/' . $model->svalue . '/member/order',
            '@app/modules/grave/views/member/ins' => '@app/web/theme/' . $model->svalue . '/member/ins',
            '@app/modules/memorial/views/member/default' => '@app/web/theme/' . $model->svalue . '/member/memorial',
            '@app/core/views/single' => '@app/web/theme/' . $model->svalue . '/member/msg',
        ];
    }

    public function success($url = [] ,$sec = 3){
        $url= empty($url)? ['/admin']: $url;
        $url= \yii\helpers\Url::toRoute($url);
        return $this->renderPartial('@app/core/views/single/msg',['gotoUrl'=>$url,'sec'=>$sec]);
    }

    public function error($msg= '',$sec = 3){
//    	\Yii::$app->getSession()->setFlash('error', '错误');
        return $this->renderPartial('@app/core/views/single/msg',['errorMessage'=>$msg,'sec'=>$sec]);
    }
}
