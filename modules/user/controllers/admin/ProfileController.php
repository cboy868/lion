<?php

namespace app\modules\user\controllers\admin;

use app\modules\user\models\Log;
use Yii;
use app\modules\user\models\User;
use app\modules\user\models\UserForm;
use app\modules\user\models\UserField;
use app\modules\user\models\Addition;
use app\modules\user\models\UserSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\core\base\Upload;

/**
 * DefaultController implements the CRUD actions for User model.
 */
class ProfileController extends BackController
{

    public function beforeAction($action)
    {

        if ($action->id == 'avatar') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }


    /**
     * Lists all User models.
     * @return mixed
     * @name 个人中心
     */
    public function actionIndex()
    {
        $model = Yii::$app->user->identity;
        $addition = $this->findAddition();

        return $this->render('index',[
            'model' => $model,
            'addition' => $addition,
            'log' => Log::getLast()
        ]);
    }


    public function actionUpdate()
    {
        $model = Yii::$app->user->identity;
        $addition = $this->findAddition();
        $attach = UserField::find()->asArray()->all();
        $post = Yii::$app->request->post();


        if ($addition->load($post)) {
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

            return $this->redirect(['update']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'attach' => $attach,
                'addition' => $addition,
            ]);
        }
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

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;


        if (\Yii::$app->request->isPost) {

            $res_name = 'avatar';
            $use = '';

            $upload = Upload::getInstanceByName('__avatar1', $res_name);
            $upload->use = $use ? $use : null;
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
    }

}
