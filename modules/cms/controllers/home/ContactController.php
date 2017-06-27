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
class ContactController extends CommonController
{

    public $mid = 3;

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

    /**
     * @name 单页面时 使用此方法
     */
    public function actionUs()
    {
        $model = new MsgForm();

        $post = Yii::$app->request->post();


        if ($model->load(Yii::$app->request->post(), '')) {


            $model->title = '网站商务咨询' . date('Y-m-d H:i');
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

}
