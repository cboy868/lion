<?php

namespace app\core\web;


use yii;
use yii\helpers\Url;

/**
 * Default controller for the `wechat` module
 */
class MemberController extends \app\core\web\Controller
{

    public $layout = "@app/core/views/layouts/member.php";


    public function init()
    {
        Yii::$app->user->loginUrl = ['member/default/login'];
        Yii::$app->errorHandler->errorAction = 'member/default/error';
        parent::init();
    }

    public function beforeAction($action)
    {
        Yii::$app->setHomeUrl(Url::toRoute(['/member']));
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
}
