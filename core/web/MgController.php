<?php

namespace app\core\web;


use yii;
/**
 * Default controller for the `wechat` module
 */
class MgController extends \app\core\web\Controller
{

    public $layout = "@app/core/views/layouts/mg.php";

    public function beforeAction($action)
    {

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
    		'site/login','site/captcha','site/logout'
    	];
    }
}
