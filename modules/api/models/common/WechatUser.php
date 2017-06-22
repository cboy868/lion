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
}
