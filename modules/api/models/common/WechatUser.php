<?php

namespace app\modules\api\models\common;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;
use yii\filters\RateLimitInterface;
use app\core\models\Attachment;
use api\common\models\ActiveRecord;


class WechatUser extends \app\modules\wechat\models\User
{
    public $is_staff;
    /**
     * @return array
     * 参数 expand=user
     */
    public function extraFields()
    {
        return [
            'user' => function($model){
                return $model->sysUser;
            },
        ];
    }

    public function getIsStaff()
    {
        if ($this->sysUser) {
            $this->is_staff = $this->sysUser->is_staff ? true : false;
            return $this->is_staff;
        }

        return false;
    }
}
