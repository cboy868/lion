<?php
namespace app\modules\api\controllers\common;

use Yii;
use yii\rest\ActiveController;

/**
 * Site controller
 */
class GoodsController extends ActiveController
{
	public $modelClass = 'api\common\models\Goods';
}
