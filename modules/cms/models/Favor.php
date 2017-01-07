<?php

namespace app\modules\cms\models;

use Yii;
use app\modules\user\models\User;
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
        'goods' => '产品',
        'post' => '文章',
        'album' => '图集' 
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%favor}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'res_id', 'created_at'], 'integer'],
            [['created_at'], 'required'],
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

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
