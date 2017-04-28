<?php

namespace app\modules\news\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%news_photo}}".
 *
 * @property integer $id
 * @property integer $news_id
 * @property string $title
 * @property string $path
 * @property string $name
 * @property integer $sort
 * @property integer $view_all
 * @property integer $com_all
 * @property string $body
 * @property string $ext
 * @property string $ip
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class NewsPhoto extends \app\core\models\Attachment
{
    const STATUS_NORMAL = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news_photo}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['news_id', 'sort', 'view_all', 'com_all', 'created_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['body'], 'string'],
            [['path', 'name'], 'required'],
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
            'news_id' => 'News ID',
            'title' => 'Title',
            'path' => 'Path',
            'name' => 'Name',
            'sort' => 'Sort',
            'view_all' => 'View All',
            'com_all' => 'Com All',
            'body' => 'Body',
            'ext' => 'Ext',
            'ip' => 'Ip',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
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

    public static function db($event)
    {
        $model = new self;
        $model->path = $event->path;
        $model->name = $event->fileName;
        $model->ext = $event->ext;
        // $model->title = $event->title;
        $model->title = substr($event->title, 0, strrpos($event->title, '.'));
        $model->created_by = Yii::$app->user->id;
        $model->save();

        return $event->sender->mid = $model->id;
    }

    /**
     * @name 取封面
     */
    public function getCover($size='')
    {
        return self::getById($this->id, $size);
    }
}
