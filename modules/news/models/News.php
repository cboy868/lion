<?php

namespace app\modules\news\models;

use Yii;

/**
 * This is the model class for table "{{%news}}".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property string $subtitle
 * @property string $summary
 * @property string $author
 * @property string $pic_author
 * @property string $video_author
 * @property string $source
 * @property integer $thumb
 * @property string $video
 * @property integer $sort
 * @property integer $view_all
 * @property integer $com_all
 * @property integer $recommend
 * @property integer $is_top
 * @property integer $type
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class News extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'thumb', 'sort', 'view_all', 'com_all', 'recommend', 'is_top', 'type', 'created_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['title', 'created_at', 'updated_at'], 'required'],
            [['summary'], 'string'],
            [['title', 'subtitle', 'video'], 'string', 'max' => 255],
            [['author', 'pic_author', 'video_author'], 'string', 'max' => 100],
            [['source'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => '分类',
            'title' => '标题',
            'subtitle' => '副标题',
            'summary' => '概要',
            'author' => '作者',
            'pic_author' => '图片作者',
            'video_author' => '视频作者',
            'source' => '来源',
            'thumb' => '封面',
            'video' => '视频',
            'sort' => '排序',
            'view_all' => '查看次数',
            'com_all' => '评论次数',
            'recommend' => '推荐',
            'is_top' => '置顶',
            'type' => '类型',
            'created_by' => '添加人',
            'created_at' => '添加时间',
            'updated_at' => '修改时间',
            'status' => '状态',
        ];
    }
}
