<?php

namespace app\modules\m\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class DefaultController extends \app\core\web\MController
{
//    public $layout = "@app/modules/m/views/layouts/m.php";
    /**
     * @inheritdoc
     */
    // public function behaviors()
    // {
    //     return [
    //         'access' => [
    //             'class' => AccessControl::className(),
    //             'only' => ['logout'],
    //             'rules' => [
    //                 [
    //                     'actions' => ['logout'],
    //                     'allow' => true,
    //                     'roles' => ['@'],
    //                 ],
    //             ],
    //         ],
    //         'verbs' => [
    //             'class' => VerbFilter::className(),
    //             'actions' => [
    //                 'logout' => ['post'],
    //             ],
    //         ],
    //     ];
    // }

    // /**
    //  * @inheritdoc
    //  */
    // public function actions()
    // {
    //     return [
    //         'error' => [
    //             'class' => 'yii\web\ErrorAction',
    //         ],
    //         'captcha' => [
    //             'class' => 'yii\captcha\CaptchaAction',
    //             'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
    //         ],
    //     ];
    // }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

//    public function init()
//    {
//        parent::init();
//        \Yii::$app->homeUrl = \yii\helpers\Url::toRoute(['/']);
//        $this->_theme();
//    }
//
//    protected function _theme() {
//
//        $model = \app\modules\sys\models\Set::findOne('theme');
//
//        $this->view->theme->pathMap = [
//            // '@app/modules/default/views/default' => '@app/web/theme/'.$model->svalue.'/home/home',
//            // '@app/modules/cms/views/default/album' => '@app/web/theme/'. $model->svalue .'/default/album',
//            // '@app/modules/cms/views/default/post' => '@app/web/theme/' . $model->svalue . '/default/post',
//            // '@app/modules/news/views/home/default' => '@app/web/theme/' . $model->svalue . '/default/news',
//            // '@app/modules/shop/views/home/default' => '@app/web/theme/' . $model->svalue . '/default/shop',
//            // '@app/modules/default/views/layouts' => '@app/web/theme/' . $model->svalue . '/default/layouts',
//
//            '@app/modules/m/views/default' => '@app/web/theme/' . $model->svalue . '/mobile/home',
//            '@app/modules/m/views/layouts' => '@app/web/theme/' . $model->svalue . '/mobile/layouts',
//            '@app/modules/news/views/m/default' => '@app/web/theme/' . $model->svalue . '/mobile/news',
//            '@app/modules/shop/views/m/default' => '@app/web/theme/' . $model->svalue . '/mobile/goods',
//
//            '@app/modules/user/views/m/default' => '@app/web/theme/' . $model->svalue . '/mobile/user',
//            '@app/modules/order/views/m/default' => '@app/web/theme/' . $model->svalue . '/mobile/order'
//        ];
//    }


}
