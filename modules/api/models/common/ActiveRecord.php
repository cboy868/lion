<?php

namespace app\modules\api\models\common;

use Yii;


/**
 * This is the model class for table "{{%shop_goods}}".
 *
 */
class ActiveRecord extends \yii\db\ActiveRecord
{
	const STATUS_ACTIVE = 1;
	const STATUS_DELETE = -1;
}
