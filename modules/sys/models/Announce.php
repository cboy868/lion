<?php

namespace app\modules\sys\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%sys_announce}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $author
 * @property integer $author_id
 * @property string $start
 * @property string $end
 * @property integer $type
 * @property integer $view_num
 * @property integer $created_at
 * @property integer $status
 */
class Announce extends \app\core\db\ActiveRecord
{
    const TYPE_SYS = 1;//系统公告
    const TYPE_WEB = 2; //网站公告

    public static function types($type=null)
    {
        $t = [
            self::TYPE_WEB => '网站公告',
            self::TYPE_SYS => '系统公告'
        ];

        if ($type!=null) {
            return isset($t[$type]) ? $t[$type] : '';
        }

        return $t;
    }





    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_announce}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['content'], 'string'],
            [['author_id', 'type', 'view_num', 'created_at', 'status'], 'integer'],
            [['start', 'end'], 'safe'],
            [['title', 'author'], 'string', 'max' => 200],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'content' => '内容',
            'author' => '作者',
            'author_id' => '作者',
            'start' => '展示开始',
            'end' => '展示结束',
            'type' => '类型',
            'view_num' => '查看次数',
            'created_at' => '添加时间',
            'status' => 'Status',
        ];
    }
}
