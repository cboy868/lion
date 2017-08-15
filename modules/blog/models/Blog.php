<?php

namespace app\modules\blog\models;

use app\modules\user\models\Track;
use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\user\models\User;
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

    const TYPE_TEXT = 1;//'文字 ';
    const TYPE_VIDEO = 2;// '视频';

    const RES_BLOG = 1; //博客类型
    const RES_ARCHIVE = 2; //档案类型
    const RES_MISS = 3;//博客类型的纪念馆追忆文章

    const STATUS_VRIFY = 0;//待审核
    const STATUS_NOVRIFY = -2;//审核未通过

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

    public static function status($status = null)
    {
        $s = [
            self::STATUS_DEL => '删除',
            self::STATUS_NORMAL => '审核通过',
            self::STATUS_VRIFY => '待审核',
            self::STATUS_NOVRIFY => '审核未通过'
        ];

        if ($status === null) {
            return $s;
        }

        return $s[$status];
    }

    public function getPrivacyText()
    {
        return static::privacys($this->privacy);
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
            [['title', 'body'], 'required'],
            [['summary', 'body'], 'string'],
            [['thumb', 'sort', 'recommend', 'is_customer', 'is_top',
                'type', 'memorial_id', 'privacy', 'view_all', 'com_all',
                'created_by', 'created_at', 'updated_at', 'status','res'], 'integer'],
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
            'privacy' => '隐私',
            'view_all' => '查看次数',
            'com_all' => '评论次数',
            'publish_at' => '发布时间',
            'created_by' => '添加人',
            'ip' => 'Ip',
            'created_at' => '添加时间',
            'updated_at' => '更新时间',
            'status' => '状态',
            'privacy_Text' =>'隐私'
        ];
    }

    public function isOwn()
    {
        return ($this->created_by == Yii::$app->user->id);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id'=>'created_by']);
    }
    /**
     * @name 脚印
     */
    public function track($res=Track::RES_BLOG)
    {
        if (Yii::$app->user->isGuest) {
            return ;
        }
        if (Yii::$app->user->id == $this->created_by) {
            return ;
        }


        Track::create($res, $this->id);
    }
}
