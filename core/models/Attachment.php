<?php

namespace app\core\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\core\helpers\Image;

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
class Attachment extends \yii\db\ActiveRecord
{

    const STATUS_DEL = -1;
    const STATUS_ACTIVE = 1;

    public $url;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%attachment}}';
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
            [['author_id', 'sort', 'created_at', 'status'], 'integer'],
            [['desc'], 'string'],
            // [['created_at'], 'required'],
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
        $model = new self;
        $model->path = $event->path;
        $model->name = $event->fileName;
        $model->ext = $event->ext;
        $model->title = $event->title;
        $model->author_id = Yii::$app->user->id;
        $model->save();

        $rel = new AttachmentRel;
        $rel->res_name = $event->res;
        $rel->attach_id = $model->id;
        $rel->use = $event->use;
        $rel->save();

        return $event->sender->mid = $model->id;

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

        $option = ['author_id'=>$user_id, 'status'=>self::STATUS_ACTIVE];
        $count = self::find()->where($option)->count();

        $list = self::find()->where($option)
                            ->limit($limit)
                            ->orderBy(['id'=>SORT_DESC])
                            ->offset($offset)
                            ->asArray()
                            ->all();
                            
        return ['count'=>$count, 'list'=>$list];
    }

    public function getImg($size='')
    {
        if ($size) {
            $file = $this->path . '/' . $size . '@' . $this->name;
            if (is_file(Yii::getAlias('@app/web'.$file))) {
                return $file;
            }
        }
        return $this->path . '/' . $this->name;
        // return $type ? $this->path . '/' . $type . '@' . $this->name : $this->path . '/' . $this->name;
    }

    /**
     * todo 如果缩略图不存在，则生成
     */
    public static function getById($id, $size='', $default='')
    {
        $model = self::findOne($id);

        if (!$model) {
            return $default;
        }

        if ($size) {
            $file = $model->path . '/' . $size . '@' . $model->name;
            $thumb_path = Yii::getAlias('@app/web'.$file);
            $srcFile = Yii::getAlias('@app/web'.$model->path . '/' . $model->name);
            if (!is_file($thumb_path)) {
                if (is_file($srcFile)) {
                    $size = explode('x', str_replace('X', 'x', $size));
                    p($size);
                    Image::autoThumb($srcFile, $thumb_path, $size);
                } else {
                    return $default;
                }
                
            }

            return $file;
        }

        return $model->path . '/' . $model->name;
    }
}
