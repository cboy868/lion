<?php

namespace app\modules\api\models\common;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;
use yii\filters\RateLimitInterface;
use app\core\models\Attachment;
use api\common\models\ActiveRecord;


class User extends \app\modules\user\models\User
{

    public function fields()
    {

        $fields = parent::fields();
        $other = [
            //参数 cover-size=50x50&
            'avatar' => function($model){
                $size = Yii::$app->request->get('avatarSize');
                if ($size) {
                    return self::BASE_URL . $model->getAvatar($size);
                }
                return self::BASE_URL . $model->avatar;
            },

        ];

        $fields = array_merge($fields, $other);

        unset($fields['auth_key'], $fields['password_hash'], $fields['password_reset_token']);
        unset($fields['status']);

        return $fields;

    }

    /**
     * @return array
     * 参数 expand=addition
     */
    public function extraFields()
    {
        $req = Yii::$app->request;
        return [
            'addition' => function($model){
                return $model->addition;
            },
        ];
    }

}
