<?php

namespace app\core\widgets\comment;

use Yii;
use yii\base\Model;
use app\core\models\Comment as Com;
use app\modules\user\models\User;

/**
 * Signup form
 */
class CommentForm extends Model
{
    public $content;
    public $res_name;
    public $res_id;
    public $pid;
    // public $privacy;
    public $to;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'res_name', 'res_id', 'pid', 'to'], 'required'],
            [['to', 'res_id', 'pid'], 'integer'],
            [['res_name'], 'string'],
        ];
    }

    public function attributeLabels()
    {
      return array(
        'content' => '评论内容',
        'privacy' => '悄悄话'
      );
    }


    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function create()
    {
        // if ($this->validate()) {
            $comment = new Com();
            $comment->content = $this->content;
            $comment->res_name = $this->res_name;
            $comment->res_id = $this->res_id;
            $comment->pid = $this->pid;
            $comment->privacy = Com::PRIVACY_PUBLIC;
            $comment->to = $this->to;
            $comment->from = isset(Yii::$app->user->id) ? Yii::$app->user->id : 0;
            $comment->status = Com::STATUS_PUBLISH;

            if ($comment->save()) {
                return $comment;
            }
        // }

        return null;
    }
}
