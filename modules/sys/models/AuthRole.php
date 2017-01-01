<?php
namespace app\modules\sys\models;

use Yii;
use yii\base\NotSupportedException;
use app\core\helpers\Pinyin;
/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class AuthRole extends AuthItem
{
    protected $type = self::TYPE_ROLE;

    public function rules()
    {
        return [
        	[['real_title'], 'required'],
            [['type', 'level',  'created_at', 'updated_at'], 'integer'],
            [['name', 'real_title'], 'string', 'max' => 255],
            [['level'], 'default', 'value'=>self::LEVEL_ROLE],
            [['type'], 'default', 'value'=>self::TYPE_ROLE],
            [['description'], 'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'codename',
            'rule_name' => '规则名',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'real_title' => '角色名',
            'description' => '备注'
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $this->name  = strtolower(Pinyin::pinyin($this->real_title)) .'_'. uniqid();
        return true;
    }

}
