<?php

namespace app\modules\blog\models;

use app\core\models\Attachment;
use Yii;
use yii\behaviors\TimestampBehavior;
use app\core\helpers\Image;
/**
 * This is the model class for table "{{%blog_album_photo}}".
 *
 * @property integer $id
 * @property integer $album_id
 * @property string $title
 * @property string $path
 * @property string $name
 * @property integer $sort
 * @property integer $view_all
 * @property integer $com_all
 * @property string $body
 * @property string $ext
 * @property string $ip
 * @property integer $privacy
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class AlbumPhoto extends Attachment
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%blog_album_photo}}';
    }
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public static function db($event)
    {
        $post = Yii::$app->request->post();

        $model = new self;
        $model->path = $event->path;
        $model->name = $event->fileName;
        $model->ext = $event->ext;
        $model->album_id = is_numeric($post['album_id']) ? $post['album_id'] : 0;
        // $model->title = $event->title;
        $model->title = substr($event->title, 0, strrpos($event->title, '.'));
        $model->created_by = Yii::$app->user->id;
        $model->save();

        Album::updateNum($model->album_id);

        return $event->sender->mid = $model->id;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['album_id', 'sort', 'view_all', 'com_all', 'privacy', 'created_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['body'], 'string'],
            [['title', 'name', 'path'], 'required'],
            [['title', 'path', 'name', 'ip'], 'string', 'max' => 200],
            [['ext'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'album_id' => 'Album ID',
            'title' => 'Title',
            'path' => 'Path',
            'name' => 'Name',
            'sort' => 'Sort',
            'view_all' => 'View All',
            'com_all' => 'Com All',
            'body' => 'Body',
            'ext' => 'Ext',
            'ip' => 'Ip',
            'privacy' => 'Privacy',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getThumb($size='', $default="/static/images/default.png")
    {
        if ($size) {
            $size = str_replace('*', 'x', $size);
            $file = $this->path . '/' . $size . '@' . $this->name;

            $thumb_file = str_replace('upload/image', 'upload/image/'.Image::THUMB_DIR, $file);
            $thumb_path = Yii::getAlias('@app/web'.$thumb_file);

            $srcFile = Yii::getAlias('@app/web'.$this->path . '/' . $this->name);
            if (!is_file($thumb_path)) {
                if (is_file($srcFile)) {
                    $size = explode('x', str_replace('X', 'x', $size));
                    Image::autoThumb($srcFile, $thumb_path, $size, 'blog');
                } else {
                    return $default;
                }
            }
            return $thumb_file;
        }

        return $this->path . '/' . $this->name;
    }

}
