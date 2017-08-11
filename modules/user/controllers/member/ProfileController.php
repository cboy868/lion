<?php

namespace app\modules\user\controllers\member;

use Yii;
use app\modules\user\models\User;
use app\modules\user\models\UserForm;
use app\modules\user\models\UserField;
use app\modules\user\models\Addition;
use app\modules\user\models\UserSearch;
use app\core\web\MemberController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\core\base\Upload;
use app\modules\user\models\PasswdForm;


/**
 * DefaultController implements the CRUD actions for User model.
 */
class ProfileController extends MemberController
{

    public function beforeAction($action)
    {
        if ($action->id == 'avatar') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $model = Yii::$app->user->identity;
        $addition = $this->findAddition();
        $attach = UserField::find()->asArray()->all();


        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $outerTransaction = Yii::$app->db->beginTransaction();
            try {
                $addition->load($post);
                $addition->save();
                $model->load($post);
                $model->save();

                $outerTransaction->commit();
            } catch (\Exception $e) {
                echo $e->getMessage();
                $outerTransaction->rollBack();
            }

            return $this->redirect(['index']);
        }


        return $this->render('index', [
            'model'=>$model,
            'addition'=>$addition,
            'attach'=>$attach
        ]);
    }
    /**
     * Lists all User models.
     * @return mixed
     * @name 个人中心
     */
    public function actionIndex1()
    {
        $model = $this->findModel();

        $addition = $this->findAddition();

        $attach = UserField::find()->asArray()->all();

        $post = Yii::$app->request->post();

        $pwd = new PasswdForm();

        if ($pwd->load($post)) {
            if ($pwd->pwd()) {
                Yii::$app->getSession()->setFlash('success', '密码修改成功');
            } else {
                Yii::$app->getSession()->setFlash('error', '密码修改失败');
            }
        }

        if ($addition->load($post)) {
            $outerTransaction = Yii::$app->db->beginTransaction();
            try {
                $addition->load($post);
                $addition->save();
                $model->load($post);
                $model->save();

                $outerTransaction->commit();
            } catch (Exception $e) {
                echo $e->getMessage();
                $outerTransaction->rollBack();
            }

            return $this->redirect(['index']);
        }

        return $this->render('index', [
            'model' => $model,
            'attach' => $attach,
            'addition' => $addition,
            'pwd' => $pwd
        ]);
    }

    public function actionPasswd()
    {
        $pwd = new PasswdForm();
        $pwd->setScenario('passwd');

        if (Yii::$app->request->isPost) {

            $post = Yii::$app->request->post();
            if ($pwd->load($post)) {
                if ($pwd->pwd()) {
                    Yii::$app->getSession()->setFlash('success', '密码修改成功');
                    return $this->redirect('passwd');
                } else {
                    Yii::$app->getSession()->setFlash('error', '密码修改失败');
                }


            }
        }

        return $this->render('passwd', ['pwd'=>$pwd]);
    }


    protected function findModel()
    {
        if (($model = User::findOne(Yii::$app->user->id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findAddition()
    {
        $user_id = Yii::$app->user->id;

        if (($model = Addition::findOne($user_id)) !== null) {
            return $model;
        } else {
            $model = new Addition();
            $model->user_id = $user_id;
            if ($model->save()) {
                return $this->findAddition($user_id);
            }

            throw new NotFoundHttpException('The requested page does not exist.');

        }
    }

    /**
     * @name 上传头像
     */
    public function actionAvatar()
    {
        $user_id = Yii::$app->user->id;

        if (\Yii::$app->request->isPost) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;


            $upload = Upload::getInstanceByName('__avatar1', 'avatar');
            $upload->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);
            $upload->save();

            $info = $upload->getInfo();

            $model = $this->findModel($user_id);
            $model->avatar = $info['mid'];
            $model->save();

            return [
                'sourceUrl'  => true,
                'avatarUrls' => $info['path'] .'/'. $info['fileName']
            ];
        }

        return $this->render('avatar');
    }

}
