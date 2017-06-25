<?php

namespace app\modules\cms\controllers\home;

use yii;
use app\modules\cms\models\Post;
use app\modules\mod\models\Module;
use app\modules\cms\models\PostImageSearch;
use yii\web\NotFoundHttpException;
use app\modules\mod\models\Code;

/**
 * Class GraveController
 * @package app\modules\cms\controllers\home
 * @name 公墓管理系统
 */
class GraveController extends CommonController
{
    public $mid = 2;
}
