<?php

namespace app\modules\api\models\common;

use app\modules\shop\models\Type;
use Yii;
use yii\behaviors\TimestampBehavior;
use app\core\models\Attachment;
use app\modules\cms\models\Category;

/**
 * This is the model class for table "{{%post}}".
 * @property PostData[] $postDatas
 */
class Post extends \app\modules\cms\models\Post
{

}
