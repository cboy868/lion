<?php

namespace app\modules\wechat\controllers\admin;

use Yii;
use app\modules\wechat\models\Wechat;
use app\modules\wechat\models\WechatSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Wechat model.
 */
class DefaultController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Wechat models.
     * @return mixed
     */
    public function actionIndex()
    {

    	

    }
}
