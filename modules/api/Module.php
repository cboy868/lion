<?php

namespace app\modules\api;

use yii;
use yii\helpers\ArrayHelper;

class Module extends \app\core\base\Module
{

    public function init()
    {
        parent::init();


//        $a = Yii::createObject([
//            'class' => 'yii\rest\UrlRule',
//            'controller' => [
//                'v1/news',
//                'v1/order',
//                '/api/v1/goods',
//                'v1/post',
//                'v1/user'
//            ]
//        ]);
//        Yii::$app->urlManager->rules=[$a];
//        Yii::$app->urlManager->rules[]= $a;

//        p(Yii::$app->urlManager->rules);die;


        // custom initialization code goes here
    }
}
