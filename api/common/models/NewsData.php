<?php

namespace api\common\models;

use Yii;

/**
 * This is the model class for table "{{%news_data}}".
 *
 * @property integer $news_id
 * @property string $body
 * @property integer $status
 */
class NewsData extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news_data}}';
    }
}
