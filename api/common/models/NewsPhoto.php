<?php

namespace api\common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%shop_goods}}".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property integer $thumb
 * @property string $intro
 * @property string $unit
 * @property string $price
 * @property integer $num
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class NewsPhoto extends \app\core\models\Attachment
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news_photo}}';
    }
}
