<?php

namespace app\modules\memorial\controllers\home;

use app\core\models\Comment;
use app\modules\memorial\models\Memorial;
use app\modules\memorial\models\Pray;
use yii;

class DefaultController extends \app\modules\home\controllers\HomeController
{
    public function actions()
    {
        return [
            'ue-upload' => [
                'class' => 'app\core\widgets\Ueditor\UploadAction',
            ]
        ];
    }

    public function actionIndex()
    {
        #1 查找最新纪念馆4个
        $list = Memorial::find()->where(['status'=>Memorial::STATUS_ACTIVE])
                                ->orderBy('created_at desc')
                                ->limit(16)
                                ->all();

        return $this->render('index', ['list'=>$list]);
    }

    public function actionPanel()
    {
    	return $this->render('panel');
    }

    public function actionRemote()
    {
        return $this->render('remote');
    }

    public function actionView($id)
    {
        $this->layout = "@app/modules/home/views/layouts/memorial.php";

        $model = Memorial::findOne($id);

        if (!$model) {
            return $this->error('不存在此纪念馆');
        }

        //取点烛次数
        $prays = Pray::prayCount($id);

        //取评论
        $comments = Comment::getByRes('memorial', $id);

        $model->incrementView();

    	return $this->render('view', [
    	    'model'=>$model,
            'prays'=>json_encode($prays),
            'comments'=>$comments
        ]);
    }

    /**
     * @name 点烛 献花等
     */
    public function actionJisi($id)
    {
        $type = Yii::$app->request->post('type');

        $pray = new Pray();
        $pray->memorial_id = $id;
        $pray->type = $type;
        $pray->user_id = Yii::$app->user->id;

        $pray->save();

        return $this->json(Pray::prayCount($id),null, 1);
    }

    public function actionComment($id)
    {
        $model = Memorial::findOne($id);
        if (!$model) {
            return $this->json(null, null, 0);
        }
        $post = Yii::$app->request->post();
        $content = $post['content'];

        $result = Comment::create('memorial', $id, $content, 0, Comment::PRIVACY_PUBLIC, 0);

        return $this->json($result, null, 1);
    }

}
