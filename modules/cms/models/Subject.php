<?php

namespace app\modules\cms\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\core\models\Attachment;
/**
 * This is the model class for table "{{%subject}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $link
 * @property string $cover
 * @property string $path
 * @property integer $status
 * @property integer $updated_at
 * @property integer $created_at
 */
class Subject extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subject}}';
    }

    public static function cates($cate=null)
    {
        $c = Yii::$app->controller->module->params['subject_cate'];

        if ($cate === null) {
            return $c;
        }
        return $c[$cate];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'status', 'updated_at', 'created_at'], 'integer'],
            [['user_id', 'title'], 'required'],
            [['intro'], 'string'],
            [['title', 'link', 'path', 'cate'], 'string', 'max' => 200],
            [['cover'], 'safe']
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => '标题',
            'link' => '链接',
            'cover' => '封面',
            'path' => '路径',
            'status' => '状态',
            'cate' => '分类',
            'intro' => '简介',
            'updated_at' => '更新时间',
            'created_at' => '添加时间',
        ];
    }

    /**
     * @name 获取用户
     */
    public function getUser()
    {
        return $this->hasOne(\app\modules\user\models\User::className(), ['id'=>'user_id']);
    }

    /**
     * @name 获取封面
     */
    public function getImg($size=null)
    {
        return Attachment::getById($this->cover, $size);
    }
}
