<?php

namespace app\modules\cms\controllers\home;

use yii;
use app\modules\cms\models\Post;
use app\modules\mod\models\Module;
use app\modules\cms\models\PostImageSearch;
use yii\web\NotFoundHttpException;
use app\modules\mod\models\Code;
use app\modules\cms\models\MsgForm;


/**
 * ContactController implements the CRUD actions for Contact model.
 */
class ContactController extends \app\core\web\HomeController
{

    public $mid = 1;

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'maxLength' => 5, 
                'minLength' => 4 
            ]
        ];
    }

    public function actionContact() //这个要废弃
    {
        $model = new MsgForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->create()) {

                $email = Yii::$app->params['uemail'];
                Yii::$app->mailer->compose('@app/core/views/mail/msg', ['content'=>$model->intro])
                    ->setTo($email)
                    ->setSubject($model->title)
                    ->send();


                Yii::$app->session->setFlash('success', '留言成功，非常感谢您的关注,我们会尽快联系您');
                return $this->redirect(['contact']);
            }
        }
        return $this->render('contact', ['model'=>$model]);
    }


    public function actionIndex($type=null, $cid=null)
    {
        $module = Module::findOne($this->mid);
        Code::createObj('post', $this->mid);

        $c = 'Post' . $this->mid . 'Search';
        $class = '\app\modules\cms\models\mods\\' . $c;

        $searchModel = new $class;

        $params = Yii::$app->request->queryParams;
        if ($cid) {
            $params[$c]['category_id'] = $cid;
        }

        if ($type) {
            $types = Post::types();
            $type_key = array_search($type, $types);
            $params[$c]['type'] = $type_key;
        }

        $dataProvider = $searchModel->search($params);

        $data = [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'module' => $module,
            'type'  => $type
        ];

        return $this->render('index', $data);

    }

    public function actionView($id)
    {
        $module = Module::findOne($this->mid);
        $model = $this->findModel($id);
        $method = '_' . Post::types($model->type) . 'View';
        return $this->$method($module, $model);
    }

    private function _textView($module, $model)
    {
        return $this->render('text', [
            'model' => $model,
            'mInfo' => $module
        ]);
    }

    /**
     * @name 单页面时 使用此方法
     */
    public function actionUs()
    {
        $model = new MsgForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->res_name = 'web';
            $model->res_id = 0;
            if ($model->create()) {

//                $email = Yii::$app->params['uemail'];
//                Yii::$app->mailer->compose('@app/core/views/mail/msg', ['content'=>$model->intro])
//                    ->setTo($email)
//                    ->setSubject($model->title)
//                    ->send();

                Yii::$app->session->setFlash('success', '留言成功，非常感谢您的关注,我们会尽快联系您');
                return $this->redirect(['us']);
            }
        }

        $module = Module::findOne($this->mid);

        return $this->render('us', ['module'=>$module->toArray(),'model'=>$model]);
    }

    public function actionMsg()
    {
        $post = Yii::$app->request->post();


        $model = new MsgForm();

        $model->load($post, '');

        $model->res_name = 'web';
        $model->res_id = 0;
        $model->intro = implode(',', $post['problem']);

        if ($model->create()) {
            Yii::$app->session->setFlash('success', '恭喜,留言成功');
        } else {
            Yii::$app->session->setFlash('success', '留言失败，请重试');
        }

        return $this->redirect($_SERVER["HTTP_REFERER"]);
    }

    private function _imageView($module, $model)
    {
        $searchModel = new PostImageSearch();
        $params = Yii::$app->request->queryParams;
        $params['PostImageSearch']['mid'] = $module->id;
        $params['PostImageSearch']['post_id'] = $model->id;

        $dataProvider = $searchModel->search($params);

        return $this->render('image', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'module' => $module,
        ]);
    }

    protected function findModel($id)
    {
        Code::createObj('post', $this->mid);

        $class = '\app\modules\cms\models\mods\Post' . $this->mid;
        if (($model = $class::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

   
}
