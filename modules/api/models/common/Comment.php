<?php

namespace app\modules\api\models\common;

use app\core\base\Pagination;
use Yii;
use yii\behaviors\TimestampBehavior;
use api\common\models\user\User;

/**
 * This is the model class for table "{{%comment}}".
 *
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
                return self::$base_url . $model->fromUser->getAvatar($size);
            }

        ];

        $fields = array_merge($fields, $other);

        unset($fields['thumb']);
        unset($fields['sort']);
        unset($fields['status']);

        return $fields;

    }

    public static function add($res_name, $res_id, $content, $uid, $pid=0, $privacy=self::PRIVACY_PUBLIC, $to=0)
    {
        $comment = new self();
        $comment->res_name = $res_name;
        $comment->res_id = $res_id;
        $comment->content = $content;
        $comment->pid =$pid;
        $comment->privacy = $privacy;
        $comment->from = $uid;
        $comment->to = $to;
        return $comment->save();
    }

}
