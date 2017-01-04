<?php

namespace app\modules\cms\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\core\models\Attachment;

/**
 * This is the model class for table "{{%album}}".
 *
 * @property integer $id
 * @property integer $author_id
 * @property integer $category_id
 * @property string $title
 * @property integer $thumb
 * @property integer $sort
 * @property integer $view_all
 * @property integer $com_all
 * @property integer $photo_num
 * @property integer $recommend
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class Album extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%album}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by', 'category_id', 'thumb', 'sort', 'view_all', 'com_all', 'photo_num', 'recommend', 'created_at', 'updated_at', 'status'], 'integer'],
            [['title', 'category_id'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['author'], 'string', 'max' => 100],
            [['intro'], 'string'],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author' => '作者',
            'created_by' => '添加人',
            'category_id' => '分类',
            'title' => '相册名',
            'thumb' => '封面',
            'intro' => '介绍',
            'sort' => '排序',
            'view_all' => '查看次数',
            'com_all' => '评论次数',
            'photo_num' => '照片数量',
            'recommend' => '推荐',
            'created_at' => '相册创建时间',
            'updated_at' => '相册修改时间',
            'status' => '状态',
        ];
    }

    public function getImg($size)
    {
        return AlbumImage::getById($this->thumb, $size);
    }
}
