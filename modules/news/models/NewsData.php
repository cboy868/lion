<?php

namespace app\modules\news\models;

use Yii;

/**
 * This is the model class for table "{{%news_data}}".
 *
 * @property integer $news_id
 * @property string $body
 * @property integer $status
 */
class NewsData extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news_data}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['body'], 'string'],
            [['status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'news_id' => 'News ID',
            'body' => 'Body',
            'status' => 'Status',
        ];
    }
}
