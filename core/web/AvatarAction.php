<?php
namespace app\core\web;

use yii;
use yii\base\Action;
use app\core\base\Upload;

class AvatarAction extends Action
{

	public $view;

    public function init()
    {
        parent::init();

        $this->controller->enableCsrfValidation = false;

    }

    public function run()
    {
    	return $this->avatar();
    }



    

}