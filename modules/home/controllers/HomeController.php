<?php

namespace app\modules\home\controllers;

use Yii;
use app\core\helpers\FileHelper;

class HomeController extends \app\core\web\HomeController
{

    public $layout = 'home.php';

    public function init()
    {
    	parent::init();

		\Yii::$app->homeUrl = \yii\helpers\Url::toRoute(['/home']);
		$this->_theme();

    }

    protected function _theme() {
    	$model = \app\modules\sys\models\Set::findOne('theme');
		$this->view->theme->pathMap['@app/modules/home/views/site'] = '@app/web/theme/' . $model->svalue;
        $this->view->theme->pathMap['@app/modules/home/views/layouts'] = '@app/web/theme/' . $model->svalue;


        p($this->view->theme->pathMap);die;
	}
	
}
