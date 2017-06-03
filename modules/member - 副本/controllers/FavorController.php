<?php

namespace app\modules\member\controllers;

use yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\modules\member\models\LoginForm;

class FavorController extends \app\core\web\MemberController
{

    /**
     * @name 管理后台首页
     */
    public function actionCreate()
    {
        return $this->json();
    }

   

}
