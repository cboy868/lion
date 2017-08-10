<?php

namespace app\modules\blog\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%blog_album}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $summary
 * @property integer $thumb
 * @property string $body
 * @property integer $sort
 * @property integer $recommend
 * @property integer $is_customer
 * @property integer $is_top
 * @property integer $memorial_id
 * @property integer $privacy
 * @property integer $view_all
 * @property integer $com_all
 * @property integer $num
 * @property integer $created_by
 * @property string $ip
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class Album extends \app\core\db\ActiveRecord
{
    const PRIVACY_PRIVATE = 2;
    const PRIVACY_PUBLIC = 1;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%blog_album}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public static function privacys($privacy =null)
    {
        $p = [
            self::PRIVACY_PUBLIC => '公开',
            self::PRIVACY_PRIVATE=> '私密'
        ];

        if ($privacy === null) {
            return $p;
        }

        return $p[$privacy];
    }


    public function getPrivacyText()
    {
        return static::privacys($this->privacy);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['summary', 'body'], 'string'],
            [['thumb', 'sort', 'recommend', 'is_customer', 'is_top', 'memorial_id', 'privacy', 'view_all', 'com_all', 'num', 'created_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['title'], 'string', 'max' => 255],
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
            'title' => '相册名',
            'summary' => '简介',
            'thumb' => '封面',
            'body' => '介绍',
            'sort' => 'Sort',
            'recommend' => '推荐',
            'is_customer' => 'Is Customer',
            'is_top' => 'Is Top',
            'memorial_id' => 'Memorial ID',
            'privacy' => '隐私',
            'view_all' => '查看次数',
            'com_all' => '评论次数',
            'num' => '照片数量',
            'created_by' => '创建人',
            'ip' => 'Ip',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'status' => 'Status',
        ];
    }

    public function getCover($size, $default="/static/images/default.png")
    {
        return AlbumPhoto::getById($this->thumb, $size);
    }
}
