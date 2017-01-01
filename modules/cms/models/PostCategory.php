<?php

namespace app\modules\cms\models;

use Yii;

/**
 * This is the model class for table "{{%post_category}}".
 *
 */
class PostCategory extends \app\core\models\Category
{

    public $covert;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post_category}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => '父级',
            'level' => '层级',
            'code' => 'Code',
            'name' => '分类名称',
            'cover' => '封面',
            'body' => '描述',
            'seo_title' => 'Seo 标题',
            'seo_keywords' => 'Seo 关键词',
            'seo_description' => 'Seo 描述',
            'created_at' => '添加时间',
            'status' => '状态',
            'covert' => '封面'
        ];
    }
}