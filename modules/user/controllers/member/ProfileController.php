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


    /**
     * Lists all User models.
     * @return mixed
     * @name 个人中心
     */
    public function actionIndex()
    {
        $model = $this->findModel();

        $addition = $this->findAddition();

        $attach = UserField::find()->asArray()->all();


        $post = Yii::$app->request->post();


        if ($addition->load($post)) {
            $outerTransaction = Yii::$app->db->beginTransaction();
            try {
                $addition->load($post);
                $addition->save();

                $outerTransaction->commit();
            } catch (Exception $e) {
                echo $e->getMessage();
                $outerTransaction->rollBack();
            }

            return $this->redirect(['index']);
        } else {
            return $this->render('index', [
                'model' => $model,
                'attach' => $attach,
                'addition' => $addition,
            ]);
        }
    }


    public function actionUpdate($id)
    {
        
    }

    protected function findModel($id)
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

            $upload->save();

            $info = $upload->getInfo();

            $avatar = $info['mid'];

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
