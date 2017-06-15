<?php

namespace api\common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\mod\models\Code;
use app\core\models\Attachment;

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
 */
class PostImage extends \app\core\models\Attachment
{

    public $url;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post_image}}';
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
            [['author_id', 'sort', 'created_at', 'status', 'view_all', 'com_all', 'post_id', 'mod'], 'integer'],
            [['desc'], 'string'],
            [['post_id', 'mod'], 'required'],
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
            'post_id' => '图册id',
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

        $album_id = isset($event->data['album_id']) ? $event->data['album_id'] : $post['album_id'];
        $mid = isset($event->data['mid']) ? $event->data['mid'] : $post['mid'];

        $model = new self;
        $model->path = $event->path;
        $model->name = $event->fileName;
        $model->ext = $event->ext;
        // $model->title = $event->title;
        $model->title = substr($event->title, 0, strrpos($event->title, '.'));
        $model->author_id = Yii::$app->user->id;
        $model->post_id = $album_id;
        $model->mod = $mid;
        $model->save();

        Code::createObj('post', $mid);

        $class = '\app\modules\cms\models\mods\Post' . $mid;

        $album = $class::findOne($album_id);

        if (!$album->thumb) {
            $album->thumb = $model->id;
        }
        $album->updateNum();

        return $event->sender->mid = $model->id;
    }

    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id'=>'post_id']);
    }

}
