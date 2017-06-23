<?php

namespace app\modules\memorial\controllers\m;


use app\modules\memorial\models\Memorial;
use app\modules\memorial\models\Pray;
use app\core\models\Comment;
use yii;
use app\modules\api\models\common\WechatUser;
use app\core\helpers\ArrayHelper;
use yii\filters\Cors;
class DefaultController extends \app\core\web\MController
{
    public function behaviors() {

        $behaviors = parent::behaviors();

        return ArrayHelper::merge([
            [
                'class' => Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                ]
            ],
        ], $behaviors);
    }

    public function actions()
    {
        return [
            'ue-upload' => [
                'class' => 'app\core\widgets\Ueditor\UploadAction',
            ]
        ];
    }

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)){
            $this->initWechat();
            $session = Yii::$app->getSession();

            $wechat_user = $session->get('wechat.wechat_user');

            $this->wechat_user = WechatUser::findOne($wechat_user->id);

            if ($session->has('wechat.sys_user')) {
                $this->sys_user = $session->get('wechat.sys_user');
            }
            return true;
        }
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
//            'prays'=>json_encode($prays),
//            'comments'=>$comments,
            'wechat' => ArrayHelper::toArray($this->wechat_user)
        ]);

//        return $this->render('view', [
//            'model'=>$model,
//            'wechat' => ArrayHelper::toArray($this->wechat_user)
//        ]);
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
