<?php

namespace app\modules\wechat\models;

use Yii;

/**
 * This is the model class for table "{{%wechat_menu_main}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $type
 * @property integer $is_active
 * @property integer $gender
 * @property integer $tag
 * @property integer $client_platform_type
 * @property integer $language
 * @property string $country
 * @property string $province
 * @property string $city
 * @property integer $created_at
 */
class MenuMain extends \app\core\db\ActiveRecord
{
    const TYPE_NORMAL = 1;
    const TYPE_PERSONAL = 2;




    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wechat_menu_main}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'created_at'], 'required'],
            [['type', 'is_active', 'gender', 'tag', 'client_platform_type', 'language', 'created_at'], 'integer'],
            [['name', 'country', 'province', 'city'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '菜单组名',
            'type' => '类型',
            'is_active' => '激活',
            'gender' => '性别',
            'tag' => '标签 ',
            'client_platform_type' => '客户端系统类型',
            'language' => '语言',
            'country' => '国家',
            'province' => '省',
            'city' => '城市',
            'created_at' => '添加时间',
        ];
    }

    public static function genders($gender=null)
    {
        $g = [
            self::GENDER_NO => '不限',
            self::GENDER_MALE => '男',
            self::GENDER_FMALE => '女'
        ];

        if ($gender === null) {
            return $g;
        }

        return $g[$gender];
    }

    public static function languages($lg=null)
    {
        $l = Yii::$app->getModule('wechat')->params['menu']['language'];

        if ($lg === null) return $l;
        return $l[$lg];
    }

    public static function platform($plat=null)
    {
        $p = Yii::$app->getModule('wechat')->params['menu']['platform'];
        if ($plat === null) return $p;
        return $p[$plat];
    }

    public static function tag()
    {

    }

}
