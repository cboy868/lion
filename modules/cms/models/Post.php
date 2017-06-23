<?php

namespace app\modules\cms\models;

use app\modules\shop\models\Type;
use Yii;
use yii\behaviors\TimestampBehavior;
use app\core\models\Attachment;
use app\modules\cms\models\Category;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property integer $id
 * @property integer $author_id
 * @property integer $category_id
 * @property string $title
 * @property string $subtitle
 * @property string $summary
 * @property integer $thumb
 * @property string $ip
 * @property integer $view_all
 * @property integer $com_all
 * @property integer $recommend
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 *
 * @property PostData[] $postDatas
 */
class Post extends \app\core\db\ActiveRecord
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

    public static function tableName()
    {

        return "{{%post}}";
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
            [['created_by', 'category_id', 'view_all', 'com_all', 'recommend', 'created_at', 'updated_at', 'status'], 'integer'],
            [['summary', 'body'], 'string'],
            [['body', 'title' ,'category_id'], 'required', 'on' => ['text']],

            [['title', 'category_id'], 'required', 'on' => ['image']],
            [['title', 'subtitle'], 'string', 'max' => 255],
            [['author'], 'string', 'max' => 100],
            [['ip'], 'string', 'max' => 64],
            [['thumb'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author' => '作者',
            'created_by' => '添加人',
            'category_id' => '分类',
            'title' => '标题',
            'subtitle' => '副标题',
            'summary' => '摘要',
            'thumb' => '封面',
            'ip' => 'Ip',
            'view_all' => '查看次数',
            'com_all' => '评论次数',
            'recommend' => '推荐',
            'created_at' => '添加时间',
            'updated_at' => '更新时间',
            'status' => '状态',
            'body' => '主内容'
        ];
    }

    public function getCover($size='')
    {
        return PostImage::getById($this->thumb, $size);
    }

    public function getCreatedBy()
    {
        return $this->hasOne(\app\modules\user\models\User::className(), ['id'=>'created_by']);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id'=>'category_id']);
    }

    public function getImages($size=null)
    {
        if ($this->type != self::TYPE_IMAGE) return ;

        $table = static::tableName();
        $table = str_replace(['{{', '}}'], '', $table);
        $mod = substr($table, strpos($table, '_')+1);

        $list = PostImage::find()->where(['mod'=>$mod, 'post_id'=>$this->id])->all();

        $result = [];

        foreach ($list as $v) {
            $result[$v->id] = $v->toArray();
            $result[$v->id]['url'] = PostImage::getById($v->id, $size);
        }

        return $result;
    }

    public function updateNum()
    {
        $table = static::tableName();
        $table = str_replace(['{{', '}}'], '', $table);
        $mod = substr($table, strpos($table, '_')+1);
        $count = PostImage::find()->where([
            'post_id'=>$this->id,
            'status'=>self::STATUS_NORMAL,
            'mod' => $mod
        ])->count();
        $this->photo_num = $count;
        return $this->save();
    }

}
