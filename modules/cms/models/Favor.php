<?php

namespace app\modules\cms\models;

use Yii;
use app\modules\user\models\User;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%favor}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $res_name
 * @property integer $res_id
 * @property string $title
 * @property string $res_url
 * @property integer $created_at
 */
class Favor extends \app\core\db\ActiveRecord
{

    public static $res = [
        'goods' => 'Products',
        'post' => 'Articles',
        'album' => 'Picture' 
    ];

    public static function res()
    {

        $res = self::$res;
        foreach ($res as $k => &$v) {
            $v = Yii::t('app/member', $v);
        }unset($v);

        return $res;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%favor}}';
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    Contact::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'res_id', 'created_at'], 'integer'],
            [['user_id'], 'required'],
            [['res_name', 'title'], 'string', 'max' => 200],
            [['res_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'uname' => '用户名',
            'res_name' => '收藏类型',
            'res_id' => '资源id',
            'title' => '标题',
            'res_url' => '资源连接',
            'created_at' => '添加时间',
        ];
    }

    /**
     * @name 添加收藏
     */
    public static function create($res_name, $res_id, $res_url, $title)
    {
        $model = new self;

        $model->user_id = Yii::$app->user->id;
        $model->res_name = $res_name;
        $model->res_id = $res_id;
        $model->res_url = $res_url;
        $model->title = $title;

        if ($model->save()) {
            return $model;
        }

        return null;

    }

    public static function getCountByRes($res_name, $res_id)
    {
        return self::find()->where(['res_name'=>$res_name, 'res_id'=>$res_id])->count();
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
