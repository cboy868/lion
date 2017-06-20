<?php

namespace app\modules\api\models\common;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\user\models\User;

/**
 * This is the model class for table "{{%shop_cart}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $type
 * @property integer $goods_id
 * @property integer $sku_id
 * @property integer $num
 * @property integer $created_at
 */
class Sku extends \app\modules\shop\models\Sku
{

}
