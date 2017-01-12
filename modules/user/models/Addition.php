<?php

namespace app\modules\user\models;

use Yii;
use app\core\helpers\ArrayHelper;
use app\modules\user\models\User;
/**
 * This is the model class for table "{{%user_addition}}".
 *
 * @property integer $user_id
 * @property string $real_name
 * @property integer $gender
 * @property string $birth
 * @property integer $height
 * @property double $weight
 * @property string $qq
 * @property string $address
 * @property string $hobby
 * @property string $native_place
 * @property string $intro
 */
class Addition extends \app\core\db\ActiveRecord
{

    public $fields;

    public function init()
    {

        $mod = \Yii::$app->getRequest()->get('mod');
        $fields = UserField::find()->asArray()->all();

        $this->fields = ArrayHelper::map($fields, 'name', 'title');
        parent::init();

    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_addition}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['user_id'], 'required'],
            [['user_id', 'gender', 'height', 'logins'], 'integer'],
            [['birth'], 'safe'],
            [['weight'], 'number'],
            [['address', 'hobby', 'native_place', 'intro'], 'string'],
            [['real_name'], 'string', 'max' => 200],
            [['qq'], 'string', 'max' => 20, 'min'=>5],
        ];

        return array_merge($rules, [[array_keys($this->fields), 'safe']]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'real_name' => '实名',
            'gender' => '性别',
            'birth' => '生日',
            'height' => '身高',
            'weight' => '体重',
            'qq' => 'QQ',
            'address' => '地址',
            'hobby' => '业余爱好',
            'native_place' => '籍贯',
            'intro' => '个人介绍',
            'logins' => '登录次数'
        ] + $this->fields;
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
