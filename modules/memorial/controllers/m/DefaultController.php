<?php

namespace app\modules\memorial\controllers\m;


use app\modules\memorial\models\Memorial;
use app\modules\memorial\models\Pray;
use app\core\models\Comment;
use yii;

class DefaultController extends \app\core\web\MController
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
        return $this->render('index');
    }

    public function actionView($id)
    {
        $model = Memorial::findOne($id);
        if (!$model) {
            return $this->error('此纪念馆不存在');
        }

        //取点烛次数
        $prays = Pray::prayCount($id, ['candle','flower']);
        //取评论
        $comments = Comment::getByRes('memorial', $id, 15);
        $model->incrementView();

        return $this->render('view', [
            'model'=>$model,
            'prays'=>json_encode($prays),
            'comments'=>$comments
        ]);

        return $this->render('view', ['model'=>$model]);
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

        return $this->json(Pray::prayCount($id, ['candle','flower']),null, 1);
    }

    public function actionApply()
    {
        return $this->render('apply');
    }
}
