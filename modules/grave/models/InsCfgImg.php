<?php

namespace app\modules\grave\models;

use Yii;

/**
 * This is the model class for table "{{%grave_images_inscfg}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $desc
 * @property string $path
 * @property string $name
 * @property integer $owner_id
 * @property string $img_use
 * @property integer $sort
 * @property string $add_time
 * @property string $md5
 * @property string $ext
 * @property integer $status
 */
class InsCfgImg extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_images_inscfg}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['desc'], 'string'],
            [['path', 'name', 'img_use', 'md5', 'ext'], 'required'],
            [['owner_id', 'sort', 'status'], 'integer'],
            [['add_time'], 'safe'],
            [['title', 'path'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 64],
            [['img_use'], 'string', 'max' => 100],
            [['md5'], 'string', 'max' => 32],
            [['ext'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'desc' => 'Desc',
            'path' => 'Path',
            'name' => 'Name',
            'owner_id' => 'Owner ID',
            'img_use' => 'Img Use',
            'sort' => 'Sort',
            'add_time' => 'Add Time',
            'md5' => 'Md5',
            'ext' => 'Ext',
            'status' => 'Status',
        ];
    }
}
