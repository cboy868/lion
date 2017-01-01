<?php

namespace app\modules\shop\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\shop\models\Attr;
use app\core\traits\TreeTrait;
/**
 * This is the model class for table "{{%shop_category}}".
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


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_category}}';
    }

    public function rules()
    {
        return [
            [['pid', 'level', 'sort', 'is_leaf', 'created_at', 'status'], 'integer'],
            [['body', 'seo_description'], 'string'],
            [['name', 'type_id'], 'required'],
            [['code', 'name', 'seo_title', 'seo_keywords'], 'string', 'max' => 255],
            [['thumb'], 'safe']
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
            'type_id' => '类型',
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
        ];
    }

   

    public function getAttrs()
    {
        return $this->hasMany(Attr::className(), ['category_id' => 'id']);
    }



    public static function getThumb($thumb, $size=null)
    {
        if (!$thumb) {
            return '';
        }
        $dir = dirname($thumb);
        $file = basename($thumb);

        return $size ? $dir . '/' . $size . '@' . $file : $thumb;
    }
}
