<?php

namespace app\modules\news\models;

use Yii;

/**
 * This is the model class for table "{{%lg_news}}".
 *
 * @property integer $id
 * @property integer $news_id
 * @property string $language
 * @property string $title
 * @property string $subtitle
 * @property string $summary
 * @property integer $thumb
 * @property string $video
 * @property string $body
 */
class LgNews extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%lg_news}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['news_id', 'language', 'summary', 'body'], 'required'],
            [['news_id', 'thumb'], 'integer'],
            [['summary', 'body'], 'string'],
            [['language'], 'string', 'max' => 10],
            [['title'], 'string', 'max' => 200],
            [['subtitle', 'video'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'news_id' => 'News ID',
            'language' => 'Language',
            'title' => 'Title',
            'subtitle' => 'Subtitle',
            'summary' => 'Summary',
            'thumb' => 'Thumb',
            'video' => 'Video',
            'body' => 'Body',
        ];
    }
}
