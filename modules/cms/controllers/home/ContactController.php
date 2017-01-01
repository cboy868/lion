<?php

namespace app\modules\cms\controllers\home;

use Yii;

use app\modules\cms\models\ContactSearch;
use app\core\web\HomeController;
use yii\filters\VerbFilter;

/**
 * ContactController implements the CRUD actions for Contact model.
 */
class ContactController extends HomeController
{
   

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'maxLength' => 5, 
                'minLength' => 4 
            ]
        ];
    }

   
}
