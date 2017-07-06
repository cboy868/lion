<?php
namespace api\common\controllers;

use api\common\models\user\User;
use Yii;
use app\core\base\Upload;
use yii\helpers\ArrayHelper;
use yii\filters\auth\QueryParamAuth;
use yii\web\Response;
use yii\filters\Cors;
use yii\web\NotFoundHttpException;
/**
 * Site controller
 */
class UserController extends Controller
{
	public $modelClass = 'api\common\models\user\User';

    public function behaviors()
    {
        return ArrayHelper::merge([
            [
                'class' => Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                ]
            ],
        ], parent::behaviors());
    }

    public function actions() {
        $actions = parent::actions();
        unset($actions['delete'], $actions['create'], $actions['view']);
        return $actions;
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        $addition = $model->addition;

        return  ArrayHelper::merge($model->toArray(), $addition->toArray());
    }



    public function actionAvatar()
    {
        $outerTransaction = Yii::$app->db->beginTransaction();

        try {
            $post = Yii::$app->request->post();

            $user = $this->findModel($post['uid']);
            $upload = Upload::getInstanceByName('avatar', 'user');

            if ($upload) {
                $upload->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\helpers\Image', 'thumb']);
                $upload->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);
                $upload->save();

                $info = $upload->getInfo();
                $user->avatar = $info['mid'];
            }

            $outerTransaction->commit();
        } catch (\Exception $e) {
            $outerTransaction->rollBack();
            return ['errno'=>1, 'error'=>'上传头像失败'];

        }

        return $this->imgBaseUrl . $user->getAvatar('36x36');

    }


    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
