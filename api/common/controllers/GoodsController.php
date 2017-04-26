<?php
namespace api\common\controllers;

use Yii;
use yii\rest\ActiveController;

/**
 * Site controller
 */
class GoodsController extends ActiveController
{
	public $modelClass = 'api\common\models\Goods';
}
