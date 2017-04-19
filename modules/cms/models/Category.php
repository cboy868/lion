<?php

namespace app\modules\cms\models;

use Yii;
/**
 * This is the model class for table "{{%cms_category}}".
 *
 * @property integer $id
 * @property integer $pid
 * @property string $res_name
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
        return '{{%cms_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'level', 'cover', 'sort', 'is_leaf', 'created_at', 'status'], 'integer'],
            [['body', 'seo_description'], 'string'],
            [['name'], 'required'],
            [['res_name', 'code', 'name', 'seo_title', 'seo_keywords'], 'string', 'max' => 255],
            [['covert'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
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


    // public static getByRes($res_name)
    // {
        
    // }
}
