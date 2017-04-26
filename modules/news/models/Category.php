<?php

namespace app\modules\news\models;

use Yii;
use app\core\helpers\ArrayHelper;
/**
 * This is the model class for table "{{%news_category}}".
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $level
 * @property string $code
 * @property string $name
 * @property integer $cover
 * @property string $body
 * @property integer $sort
 * @property integer $is_leaf
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 * @property integer $created_at
 * @property integer $status
 */
class Category extends \app\core\models\Category
{

    public $covert;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'level', 'thumb', 'sort', 'is_leaf', 'created_at', 'status'], 'integer'],
            [['name'], 'required'],
            [['body', 'seo_description'], 'string'],
            [['code', 'name', 'seo_title', 'seo_keywords'], 'string', 'max' => 255],
            [['covert'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => '父id',
            'level' => '层级',
            'code' => 'Code',
            'name' => '分类名称',
            'thumb' => '封面',
            'body' => '描述',
            'seo_title' => 'Seo 标题',
            'seo_keywords' => 'Seo 关键词',
            'seo_description' => 'Seo 描述',
            'created_at' => '添加时间',
            'status' => '状态',
            'res_name' => '资源类型',
            'covert' => '封面'
        ];
    }


}
