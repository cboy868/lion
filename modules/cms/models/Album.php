<?php

namespace app\modules\cms\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\core\models\Attachment;
use app\modules\mod\models\Module;
use app\modules\mod\models\Code;
use app\core\helpers\ArrayHelper;
use yii\data\Pagination;

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

    public function getImg($size='')
    {
        return AlbumImage::getById($this->thumb, $size);
    }



    public static function albumList($dir, $cid=0, $limit=20, $thumbSize='')
    {

        $model = Module::find()->where(['dir'=>$dir])->one();

        if (!$model) {
            return false;
        }

        Code::createObj('album', $model->id);
        $class = '\app\modules\cms\models\mods\Album' . $model->id;

        $query = $class::find()->where(['status' => Album::STATUS_NORMAL, 'category_id'=>$cid])->orderBy('sort desc');
        $count = $query->count();

        $pagination = new Pagination(['totalCount'=>$count, 'pageSize'=>$limit]);

        $list = $query->offset($pagination->offset)
                      ->limit($pagination->limit)
                      ->all();

        $result = [];
        foreach ($list as $k=>$v) {
            $result[$k] = ArrayHelper::toArray($v);
            $result[$k]['thumb'] = $v->getImg($thumbSize);
        }

        return ['list' => $result, 'modinfo'=>$model, 'pagination'=>$pagination];
    }

    public static function photoList($dir, $album_id, $limit=2, $thumbSize='')
    {
        $model = Module::find()->where(['dir'=>$dir])->one();
        if (!$model) {
            return false;
        }

        $query = AlbumImage::find()->where(['mod'=>$model->id, 'album_id'=>$album_id, 'status'=>AlbumImage::STATUS_NORMAL])
                                   ->orderBy('sort desc');
        $count = $query->count();
        $pagination = new Pagination(['totalCount'=>$count, 'pageSize'=>$limit]);

        $list = $query->offset($pagination->offset)
                      ->limit($pagination->limit)
                      ->all();
        $result = [];
        foreach ($list as $k => $v) {
            $result[$k] = ArrayHelper::toArray($v);
            $result[$k]['thumb'] = $v->getImgBySrc($thumbSize);
        }

        return ['list' => $result, 'modinfo'=>$model, 'pagination'=>$pagination];

    }

    /**
     * @name 更新图片数量 
     */
    public function updateNum()
    {
        $table = static::tableName();
        $table = str_replace(['{{', '}}'], '', $table);
        $mod = substr($table, strpos($table, '_')+1);
        $count = AlbumImage::find()->where([
            'album_id'=>$this->id,
            'status'=>self::STATUS_NORMAL,
            'mod' => $mod
            ])->count();
        $this->photo_num = $count;
        return $this->save();
    }
}


