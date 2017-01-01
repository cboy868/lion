<?php

namespace app\modules\cms\models;

use Yii;

/**
 * This is the model class for table "{{%post_attach}}".
 *
 * @property integer $id
 * @property integer $res_id
 * @property integer $author_id
 * @property string $title
 * @property string $path
 * @property string $name
 * @property integer $sort
 * @property string $desc
 * @property string $ext
 * @property integer $created_at
 * @property integer $status
 */
class PostAttach extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post_attach}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['res_id', 'author_id', 'sort', 'created_at', 'status'], 'integer'],
            [['desc'], 'string'],
            [['created_at'], 'required'],
            [['title', 'path', 'name'], 'string', 'max' => 255],
            [['ext'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'res_id' => 'Res ID',
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
}
