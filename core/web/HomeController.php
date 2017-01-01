<?php

namespace app\core\web;

/**
 * Default controller for the `wechat` module
 */
class HomeController extends \app\core\web\Controller
{

	public $layout = "@app/core/views/layouts/home.php";

	// public $layout = "home.php";

	public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            return true;
        }
    }
}
