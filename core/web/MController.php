<?php

namespace app\core\web;
/**
 * Default controller for the `wechat` module
 */
class MController extends \app\core\web\Controller
{
	public $layout = "@app/core/views/layouts/m.php";

	public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            return true;
        }
    }
}
