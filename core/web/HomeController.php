<?php

namespace app\core\web;

/**
 * Default controller for the `wechat` module
 */
class HomeController extends \app\core\web\Controller
{

//	public $layout = "@app/core/views/layouts/home.php";
    public $layout = "@app/modules/home/views/layouts/home.php";


    public function init()
    {
        parent::init();
        \Yii::$app->homeUrl = \yii\helpers\Url::toRoute(['/']);
        $this->_theme();
    }

    protected function _theme() {
        $model = \app\modules\sys\models\Set::findOne('theme');

        $this->view->theme->pathMap = [
            '@app/modules/home/views/default' => '@app/web/theme/'.$model->svalue.'/home/home',
            '@app/modules/cms/views/home/album' => '@app/web/theme/'. $model->svalue .'/home/images',
            '@app/modules/cms/views/home/post' => '@app/web/theme/' . $model->svalue . '/home/post',
            '@app/modules/cms/views/home/message' => '@app/web/theme/' . $model->svalue . '/home/message',
            '@app/modules/news/views/home/default' => '@app/web/theme/' . $model->svalue . '/home/news',
            '@app/modules/shop/views/home/default' => '@app/web/theme/' . $model->svalue . '/home/shop',
            '@app/modules/home/views/layouts' => '@app/web/theme/' . $model->svalue . '/home/layouts',
            '@app/modules/grave/views/home/default' => '@app/web/theme/' . $model->svalue . '/home/grave',
            '@app/modules/blog/views/home/default' => '@app/web/theme/' . $model->svalue . '/home/blog',
            '@app/modules/memorial/views/home/default' => '@app/web/theme/' . $model->svalue . '/home/memorial',
        ];
    }

	// public $layout = "home.php";

	public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            return true;
        }
    }

    public function success($url = [] ,$sec = 3){
        $url= empty($url)? ['/admin']: $url;
        $url= \yii\helpers\Url::toRoute($url);
        return $this->renderPartial('@app/core/views/single/msg',['gotoUrl'=>$url,'sec'=>$sec]);
    }

    public function error($msg= '',$sec = 3){
//    	\Yii::$app->getSession()->setFlash('error', '错误');
        return $this->renderPartial('@app/core/views/single/msg',['errorMessage'=>$msg,'sec'=>$sec]);
    }
}
