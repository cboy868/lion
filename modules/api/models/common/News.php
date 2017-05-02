<?php

namespace app\api\models\common;

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
class News extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news}}';
    }

    /**
     * @name 取封面
     */
    public function getCover($size='')
    {
        return NewsPhoto::getById($this->thumb, $size);
    }
}
