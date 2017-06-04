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
            [['news_id', 'language'], 'required'],
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
            'title' => Yii::t('app/news', 'title'),
            'subtitle' => Yii::t('app/news', 'subtitle'),
            'summary' => Yii::t('app/news', 'summary'),
            'thumb' => Yii::t('app/news', 'thumb'),
            'video' => Yii::t('app/news', 'video'),
            'body' => Yii::t('app/news', 'body'),
        ];
    }
}
