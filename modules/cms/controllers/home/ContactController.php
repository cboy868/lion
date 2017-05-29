<?php

namespace app\modules\cms\controllers\home;

use Yii;


/**
 * ContactController implements the CRUD actions for Contact model.
 */
class ContactController extends \app\core\web\HomeController
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
