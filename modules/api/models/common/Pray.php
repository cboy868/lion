<?php

namespace app\modules\api\models\common;

use app\core\models\Attachment;
use app\modules\grave\models\Dead;
use app\modules\grave\models\Tomb;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%memorial}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $tomb_id
 * @property string $title
 * @property string $custom_title
 * @property string $cover
 * @property string $intro
 * @property integer $privacy
 * @property integer $view_all
 * @property integer $com_all
 * @property integer $tpl
 * @property integer $status
 * @property integer $updated_at
 * @property integer $created_at
 */
class Pray extends \app\modules\memorial\models\Pray
{

}
