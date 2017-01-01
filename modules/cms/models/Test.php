<?php

namespace app\modules\cms\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property integer $id
 * @property integer $author_id
 * @property integer $category_id
 * @property string $title
 * @property string $subtitle
 * @property string $summary
 * @property integer $thumb
 * @property string $ip
 * @property integer $view_all
 * @property integer $com_all
 * @property integer $recommend
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 *
 * @property PostData[] $postDatas
 */
class Test extends \app\core\db\ActiveRecord
{


    
}
