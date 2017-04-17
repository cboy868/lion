<?php

namespace app\modules\cms\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\mod\models\Code;

/**
 * This is the model class for table "{{%attachment}}".
 *
 * @property integer $id
 * @property integer $author_id
 * @property string $title
 * @property string $path
 * @property string $name
 * @property integer $sort
 * @property string $desc
 * @property string $ext
 * @property integer $created_at
 * @property integer $status
 *
 * @property AttachmentRel[] $attachmentRels
 */
class AlbumImage extends \yii\db\ActiveRecord
{

    public $url;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%album_image}}';
    }

    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at']
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_id', 'sort', 'created_at', 'status', 'view_all', 'com_all', 'album_id', 'mod'], 'integer'],
            [['desc'], 'string'],
            [['album_id', 'mod'], 'required'],
            [['title', 'path', 'name'], 'string', 'max' => 255],
            [['ext'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'album_id' => '图册id',
            'mod' => '所属模块',
            'author_id' => 'Author ID',
            'title' => 'Title',
            'path' => 'Path',
            'name' => 'Name',
            'sort' => 'Sort',
            'desc' => 'Desc',
            'ext' => 'Ext',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }

    /**
     * @name 图片信息存入数据库
     */
    public static function db($event)
    {

        $post = Yii::$app->request->post();

        
        $model = new self;
        $model->path = $event->path;
        $model->name = $event->fileName;
        $model->ext = $event->ext;
        // $model->title = $event->title;
        $model->title = substr($event->title, 0, strrpos($event->title, '.'));
        $model->author_id = Yii::$app->user->id;
        $model->album_id = $post['album_id'];
        $model->mod = $post['mod'];
        $model->save();

        Code::createObj('album', $post['mod']);

        $class = '\app\modules\cms\models\mods\Album' . $post['mod'];

        $album = $class::findOne($post['album_id']);

        if (!$album->thumb) {
            $album->thumb = $model->id;
            $album->save();
        }

        return $event->sender->mid = $model->id;

    }

    public function getAlbum()
    {
        return $this->hasOne(Category::className(),['id'=>'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRels()
    {
        return $this->hasMany(AttachmentRel::className(), ['attach_id' => 'id']);
    }

    public static function getImgByUserId($user_id, $offset=0, $limit=20)
    {

        $option = ['author_id'=>$user_id, 'status'=>1];
        $count = self::find()->where($option)->count();

        $list = self::find()->where($option)
                            ->limit($limit)
                            ->orderBy(['id'=>SORT_DESC])
                            ->offset($offset)
                            ->asArray()
                            ->all();
                            
        return ['count'=>$count, 'list'=>$list];
    }

    public function getImg($type='')
    {

        if ($type) {
            $file = $this->path . '/' . $type . '@' . $this->name;
            if (is_file(Yii::getAlias('@app/web'.$file))) {
                return $file;
            }
        }
        return $this->path . '/' . $this->name;
    }

    public static function getById($id, $size='', $default='')
    {
        $model = self::findOne($id);

        if (!$model) {
            return $default;
        }

        if ($size) {
            $file = $model->path . '/' . $size . '@' . $model->name;

            if (is_file(Yii::getAlias('@app/web'.$file))) {
                return $file;
            }
        }

        return $model->path . '/' . $model->name;
    }
}
