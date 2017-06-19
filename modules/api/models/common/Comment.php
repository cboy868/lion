<?php

namespace app\modules\api\models\common;

use app\core\base\Pagination;
use Yii;
use yii\behaviors\TimestampBehavior;
use api\common\models\user\User;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property integer $id
 * @property integer $from
 * @property integer $to
 * @property string $res_name
 * @property integer $res_id
 * @property integer $pid
 * @property string $content
 * @property integer $privacy
 * @property integer $status
 * @property integer $created_at
 */
class Comment extends \app\core\models\Comment
{
    public function fields()
    {

        $fields = parent::fields();
        $other = [
            'username' => function($model){
                return $model->fromUser->username;
            },
            'add_date' => function($model){
                return date('Y-m-d H:i', $model->created_at);
            },
            // 字段名为"email", 对应的属性名为"email_address"
            //参数 cover-size=50x50&
            'avatar' => function($model){
                $size = Yii::$app->request->get('avatarSize');
                return self::BASE_URL . $model->fromUser->getAvatar($size);
            }

        ];

        $fields = array_merge($fields, $other);

        unset($fields['thumb']);
        unset($fields['sort']);
        unset($fields['status']);

        return $fields;

    }

}
