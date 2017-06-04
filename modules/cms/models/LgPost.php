<?php

namespace app\modules\cms\models;

use Yii;

/**
 * This is the model class for table "{{%lg_post}}".
 *
 * @property integer $id
 * @property integer $post_id
 * @property string $language
 * @property string $title
 * @property string $subtitle
 * @property string $summary
 * @property string $body
 * @property integer $thumb
 */
class LgPost extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%lg_post}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'language'], 'required'],
            [['post_id', 'thumb'], 'integer'],
            [['summary', 'body'], 'string'],
            [['language'], 'string', 'max' => 10],
            [['title'], 'string', 'max' => 200],
            [['subtitle'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'language' => '语言',
            'title' => '标题',
            'subtitle' => '副标题',
            'summary' => '摘要',
            'body' => '主内容',
            'thumb' => '封面',
        ];
    }
}
