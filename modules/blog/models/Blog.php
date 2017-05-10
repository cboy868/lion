<?php

namespace app\modules\blog\models;

use Yii;
use yii\behaviors\TimestampBehavior;
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
    const PRIVACY_PRIVATE = 2;
    const PRIVACY_PUBLIC = 1;

    const TYPE_TEXT = 1;//'博客';
    const TYPE_VIDEO = 2;// '视频';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%blog}}';
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

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
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
            'title' => '标题',
            'summary' => '概要',
            'thumb' => '缩略图',
            'video' => '视频地址',
            'body' => '内容',
            'sort' => '排序',
            'recommend' => '推荐',
            'is_customer' => '是否是客户',
            'is_top' => '是否置顶',
            'type' => '类型',
            'memorial_id' => '纪念馆',
            'privacy' => '陶然',
            'view_all' => '查看次数',
            'com_all' => '评论次数',
            'publish_at' => '发布时间',
            'created_by' => '添加人',
            'ip' => 'Ip',
            'created_at' => '添加时间',
            'updated_at' => '更新时间',
            'status' => '状态',
        ];
    }
}
