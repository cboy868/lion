<?php

namespace app\modules\cms\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\core\models\Attachment;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property integer $id
 * @property integer $author_id
 * @property integer $category_id
 * @property string $title
 * @property string $subtitle
 * @property string $summary
 * @property integer $thumb
 * @property string $ip
 * @property integer $view_all
 * @property integer $com_all
 * @property integer $recommend
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 *
 * @property PostData[] $postDatas
 */
class Post extends \app\core\db\ActiveRecord
{

    public $body;


    public static function tableName()
    {

        return "{{%post}}";
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
            [['created_by', 'category_id', 'view_all', 'com_all', 'recommend', 'created_at', 'updated_at', 'status'], 'integer'],
            [['summary'], 'string'],
            [['title', 'category_id'], 'required'],
            [['title', 'subtitle'], 'string', 'max' => 255],
            [['author'], 'string', 'max' => 100],
            [['ip'], 'string', 'max' => 64],
            [['thumb'], 'safe'],
        ];
    }

    public function getThumb($type = '')
    {
        $thumb = Attachment::find()->where(['id'=>$this->thumb])->one();
        if (!$thumb) {
            return '';
        }

        return $thumb->getImg($type);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author' => '作者',
            'created_by' => '添加人',
            'category_id' => '分类',
            'title' => '标题',
            'subtitle' => '副标题',
            'summary' => '摘要',
            'thumb' => '封面',
            'ip' => 'Ip',
            'view_all' => '查看次数',
            'com_all' => '评论次数',
            'recommend' => '推荐',
            'created_at' => '添加时间',
            'updated_at' => '更新时间',
            'status' => '状态',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostData()
    {
        return $this->hasOne(PostData::className(), ['post_id' => 'id']);
    }
}
