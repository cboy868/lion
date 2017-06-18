<?php

namespace app\modules\user\controllers\m;


class DefaultController extends \app\core\web\MController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionProfile()
    {
        return $this->render('profile');
    }

    /**
     * @return string
     * 账号
     */
    public function actionAccount()
    {
        return $this->render('account');
    }

    /**
     * @return string
     * @name 投诉建议
     */
    public function actionComplaint()
    {
        return $this->render('complaint');
    }

}
