<?php
namespace app\modules\api\controllers\common;

use app\modules\user\models\Addition;
use Yii;
use app\core\base\Upload;
use yii\helpers\ArrayHelper;
use yii\filters\auth\QueryParamAuth;
use yii\web\Response;
use yii\filters\Cors;
use yii\web\NotFoundHttpException;

use app\modules\api\models\common\User;
/**
 * Site controller
 */
class UserController extends Controller
{
	public $modelClass = 'app\modules\api\models\common\User';

    public function behaviors() {

        return parent::behaviors();
    }

    public function actions() {
        $actions = parent::actions();
        unset($actions['delete'], $actions['create']);
        return $actions;
    }

//    public function actionView($id)
//    {
//        $model = $this->findModel($id);
//
//        $addition = $model->addition;
//
//        return  ArrayHelper::merge($model->toArray(), $addition->toArray());
//    }


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
            $user->save();

            $outerTransaction->commit();
        } catch (\Exception $e) {
            $outerTransaction->rollBack();
            return ['errno'=>1, 'error'=>'上传头像失败'];

        }

        return self::$base_url. $user->getAvatar('36x36');

    }

    public function actionUp()
    {
        $post = Yii::$app->request->post();

        $id =$post['id'];


        $model = $this->findModel($id);
        $addition = $model->addition;

        if (!$addition) {
            $addition = new Addition();
            $addition->user_id = $model->id;
        }

        $model->mobile = isset($post['mobile']) ? $post['mobile'] : $model->mobile;
        $model->email = isset($post['email']) ? $post['email'] : $model->email;

        $addition->address = isset($post['addition']['address']) ? $post['addition']['address'] : $addition->address;
        $addition->gender = isset($post['addition']['gender']) ? $post['addition']['gender'] : $addition->gender;
        $addition->real_name = isset($post['addition']['real_name']) ? $post['addition']['real_name'] : $addition->real_name;


        if ($model->save() && $addition->save()) {
            return true;
        }

        return ['errno'=>1, 'error'=>'更新失败，请重试'];

    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested user does not exist.');
        }
    }
}
