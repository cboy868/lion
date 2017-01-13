<?php

namespace app\modules\user\controllers\home;


class DefaultController extends \app\core\web\HomeController
{
    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * @name 忘记密码页面
     */
    public function actionForget()
    {

    }

    /**
     * @name 注册后邮箱确认页面
     */
    public function actionConfirm()
    {

    }

    /**
     * @name 忘记密码，修改密码页面
     */
    public function actionToken($code)
    {

    }
}
