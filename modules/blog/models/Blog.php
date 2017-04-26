<?php

namespace app\modules\blog\models;

use Yii;

/**
 * This is the model class for table "{{%blog}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $summary
 * @property integer $thumb
 * @property string $video
 * @property string $body
 * @property integer $sort
 * @property integer $recommend
 * @property integer $is_customer
 * @property integer $is_top
 * @property integer $type
 * @property integer $memorial_id
 * @property integer $privacy
 * @property integer $view_all
 * @property integer $com_all
 * @property string $publish_at
 * @property integer $created_by
 * @property string $ip
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class Blog extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%blog}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'created_at', 'updated_at'], 'required'],
            [['summary', 'body'], 'string'],
            [['thumb', 'sort', 'recommend', 'is_customer', 'is_top', 'type', 'memorial_id', 'privacy', 'view_all', 'com_all', 'created_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['publish_at'], 'safe'],
            [['title', 'video'], 'string', 'max' => 255],
            [['ip'], 'string', 'max' => 200],
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
            'summary' => 'Summary',
            'thumb' => 'Thumb',
            'video' => 'Video',
            'body' => 'Body',
            'sort' => 'Sort',
            'recommend' => 'Recommend',
            'is_customer' => 'Is Customer',
            'is_top' => 'Is Top',
            'type' => 'Type',
            'memorial_id' => 'Memorial ID',
            'privacy' => 'Privacy',
            'view_all' => 'View All',
            'com_all' => 'Com All',
            'publish_at' => 'Publish At',
            'created_by' => 'Created By',
            'ip' => 'Ip',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
