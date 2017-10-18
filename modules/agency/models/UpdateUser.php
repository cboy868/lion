<?php

namespace app\modules\agency\models;

use app\modules\user\models\User;

/**
 * Signup form
 */
class UpdateUser extends User
{

    public function rules()
    {
        return [
            // [['username', 'email'], 'required'],
            [['email','category'], 'required'],//为了适应没有邮箱的人
            [['status', 'created_at', 'updated_at', 'avatar', 'is_staff', 'category'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['mobile',], 'string', 'max' => 15, 'min'=>8],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email','mobile'], 'unique'],
            [['email'], 'email'],
            [['password_reset_token'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_REGISTER],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_REGISTER]],
        ];
    }


    public function getCate()
    {
        return $this->hasOne(Agency::className(), ['id'=>'category']);
    }

}
