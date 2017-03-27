<?php

namespace app\core\web;

use yii;
use yii\helpers\Url;
use app\modules\sys\rbac\DbManager;
/**
 * Default controller for the `wechat` module
 */
class BackController extends \app\core\web\Controller
{

    public $layout = "@app/core/views/layouts/admin.php";

	public function beforeAction($action)
    {
        Yii::$app->setHomeUrl(Url::toRoute(['/admin']));

        // if (!parent::beforeAction($action)) {
        //     return false;
        // }

        if (in_array(Yii::$app->user->id, $this->ignoreUser())) {
            return parent::beforeAction($action);
        }

        //检查不需要登录的action 如 site/login site/captcha
        if (in_array($action->uniqueID, $this->ignoreLogin()))
        {
            return parent::beforeAction($action);
        }

        if (\Yii::$app->user->isGuest) {
            Yii::$app->user->loginRequired();
            return false;
        }

        if(in_array($action->uniqueID, $this->ingorePermission()))
        {
            return parent::beforeAction($action);
        }   


        if (!$this->checkPermission()) {
            throw new \Exception("对不起，您没有权限进行此操作!", 1);
        }
        
        return parent::beforeAction($action);
    }

    /**
     * @name 不需要登录的动作
     */
    public function ignoreLogin()
    {
    	return [
    		'admin/default/login','admin/default/captcha'//,'admin/default/index'
    	];
    }

    public function ignoreUser()
    {
        return [1];
    }

    /**
     * @name 不需要授权的动作
     */
    public function ingorePermission()
    {
        return [
            'site/logout',
            'site/error',
            'site/index',
        ];
    }


    public function checkPermission()
    {
        $controller = Yii::$app->controller;
        $module = $controller->module->id;
        $action = $controller->action->id;

        $short_controller = substr($controller->id, strpos($controller->id, '/')+1);

        $item = implode('/', [$module, $short_controller, $action]);

        // p($item);die;

        return Yii::$app->user->can($item);
        // p(Yii::$app->user->id);die;
    }

    public function drop($id)
    {
        $model = $this->findModel($id);
        return $model->delete();
    }

    public function del($id)
    {
        $model = $this->findModel($id);
        return $model->del();
    }

    public function success($msg="恭喜！操作成功！", $url = '' ,$sec = 3){  
        if ($url) {
            $url = \yii\helpers\Url::toRoute($url);
        }
        return $this->renderPartial('@app/core/views/single/backmsg',['message'=>$msg,'gotoUrl'=>$url,'sec'=>$sec]);
    }

    public function error($msg= '',$url='',$sec = 3){
        if ($url) {
            $url = \yii\helpers\Url::toRoute($url);
        }

        return $this->renderPartial('@app/core/views/single/backmsg',['message'=>$msg,'gotoUrl'=>$url,'sec'=>$sec]);
    }
}
