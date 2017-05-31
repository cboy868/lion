<?php

namespace app\modules\news\models;

use Yii;
use yii\behaviors\TimestampBehavior;
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

    const TYPE_TEXT = 1;
    const TYPE_IMAGE = 2;
    const TYPE_VIDEO = 3;

    public $tags;

    public static $types = [
        'text'  => '文本',//文字
        'image' => '图片',//图片
        'video' => '视频'//视频
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news}}';
    }

    public static function types($type=null)
    {
        $t = [
            self::TYPE_TEXT => 'text',
            self::TYPE_IMAGE=> 'image',
            self::TYPE_VIDEO=> 'video'
        ];

        if ($type === null) {
            return $t;
        }

        return $t[$type];
    }


    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'thumb', 'sort', 'view_all', 'com_all', 'recommend', 'is_top', 'type', 'created_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['title'], 'required'],
            [['summary'], 'string'],
            [['title', 'subtitle', 'video'], 'string', 'max' => 255],
            [['author', 'pic_author', 'video_author'], 'string', 'max' => 100],
            [['source', 'tags'], 'string', 'max' => 200],
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
            'tags' => '标签/关键词',
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id'=>'category_id']);
    }

    public function getCreatedBy()
    {
        return $this->hasOne(\app\modules\user\models\User::className(), ['id'=>'created_by']);
    }

    /**
     * @name 取封面
     */
    public function getCover($size='')
    {
        return NewsPhoto::getById($this->thumb, $size);
    }

}
