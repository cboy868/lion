<?php

namespace app\core\web;

use yii;
use yii\helpers\Url;
use app\modules\sys\rbac\DbManager;
/**
 * Default controller for the `wechat` module
 */
class ProfileController extends BackController
{

    public $layout = "@app/core/views/layouts/profile.php";

}
