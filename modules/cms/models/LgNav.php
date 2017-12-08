<?php

namespace app\modules\cms\models;

use Yii;

/**
 * This is the model class for table "{{%lg_nav}}".
 *
 * @property integer $id
 * @property integer $nav_id
 * @property string $language
 * @property string $title
 * @property string $keywords
 * @property string $description
 */
class LgNav extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%lg_nav}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nav_id', 'language'], 'required'],
            [['nav_id'], 'integer'],
            [['description'], 'string'],
            [['language'], 'string', 'max' => 20],
            [['title', 'keywords'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nav_id' => 'Nav ID',
            'language' => '语言',
            'title' => 'seo标题',
            'keywords' => '关键词',
            'description' => '站点描述',
        ];
    }
}
