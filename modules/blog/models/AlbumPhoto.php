<?php

namespace app\modules\blog\models;

use Yii;

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
class AlbumPhoto extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%blog_album_photo}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['album_id', 'sort', 'view_all', 'com_all', 'privacy', 'created_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['body'], 'string'],
            [['created_at', 'updated_at'], 'required'],
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
}
