<?php
namespace app\core\widgets\comment;


use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use app\modules\user\models\User;


class CommentAction extends Action
{
   
    public function run()
    {
        $model = new CommentForm;

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model = $model->create()) {

                $success = true;
                $info = '评论成功';
                $data['comment'] = $model;

                if ($model->from) {
                    $user = User::findOne($model->from);
                    $data['user'] = [
                        'avatar' => $user->getAvatar('60x60', '/static/images/default.png'),
                        'username' => $user->username,
                        'id' => $user->id
                    ];
                }
            	
            } else {
            	$success = false;
            	$info = '评论失败';
            	$data = null;
            }

        }

        return [
			'status' => $success,
			'info' => $info,
			'data' => $data,
		];
    }
}