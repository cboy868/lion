<?php
namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

use api\common\models\NewsPhoto;
use api\common\models\NewsCategory;
/**
 * Site controller
 */
class PostController extends \api\common\controllers\PostController
{
}
