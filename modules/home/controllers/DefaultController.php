<?php
namespace app\modules\home\controllers;

use Yii;

class DefaultController extends HomeController
{
    public $layout = "@app/modules/home/views/layouts/home.php";

	public function init()
    {
    	parent::init();
		\Yii::$app->homeUrl = \yii\helpers\Url::toRoute(['/']);
		$this->_theme();

    }

	public function actionIndex()
	{
	    return $this->render('index');
	}

	public function actionAbout()
	{
		return $this->render('about');
	}

	/**
	 * @name 联系我们
	 */
	public function actionContact()
	{
		return $this->render('contact');
	}

	public function actionLogin()
	{
		return $this->render('login');
	}



    protected function _theme() {
    	$model = \app\modules\sys\models\Set::findOne('theme');

    	$this->view->theme->pathMap = [

            '@app/modules/home/views/default' => '@app/web/theme/'.$model->svalue.'/home/home',
            '@app/modules/cms/views/home/album' => '@app/web/theme/'. $model->svalue .'/home/album',
            '@app/modules/cms/views/home/post' => '@app/web/theme/' . $model->svalue . '/home/post',
            '@app/modules/news/views/home/default' => '@app/web/theme/' . $model->svalue . '/home/news',
            '@app/modules/shop/views/home/default' => '@app/web/theme/' . $model->svalue . '/home/shop',
            '@app/modules/home/views/layouts' => '@app/web/theme/' . $model->svalue . '/home/layouts',
            '@app/modules/grave/views/home/default' => '@app/web/theme/' . $model->svalue . '/home/grave',
            '@app/modules/blog/views/home/default' => '@app/web/theme/' . $model->svalue . '/home/blog',
            '@app/modules/memorial/views/home/default' => '@app/web/theme/' . $model->svalue . '/home/memorial',

    	];
	}



}
