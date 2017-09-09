<?php
namespace app\modules\api\controllers\common;

use Yii;
use app\modules\api\models\common\UserForm;
use app\modules\api\models\common\WechatUser;
use app\modules\api\models\common\User;

/**
 * Site controller
 */
class WechatProUserController extends WechatController
{
    public $modelClass = 'app\modules\api\models\common\WechatUser';

    public function behaviors() {
        return parent::behaviors();
    }

    public function actions() {
        $actions = parent::actions();
        unset($actions['delete'], $actions['create']);
        return $actions;
    }

//    public function actionUinfo($wechat_uid)
//    {
//        $class = $this->modelClass;
//
//        $model = $class::findOne($wechat_uid);
//
//        return $model;
//    }


    public function actionBind()
    {
        $post = Yii::$app->request->post();

        $user = User::findByUsername($post['uname']);

        if (!$user) {
            return ['errno'=>1, 'error'=>'用户名或密码不正确，请重试1'];
        }

        if (!$user->validatePassword($post['passwd'])) {
            return ['errno'=>1, 'error'=>'用户名或密码不正确，请重试'];
        }

        $wecheat_user = WechatUser::findOne($post['wechat_uid']);

        if ($wecheat_user->user_id) {
            return ['errno'=>1, 'error'=>'用户已绑定，如需更换，请联系工作人员'];
        }

        $wecheat_user->user_id = $user->id;

        return $wecheat_user->save();

    }


    public function actionCreate()
    {
        $post = Yii::$app->request->post();


        $wecheat_user = WechatUser::findOne($post['wechat_uid']);

        if (!$wecheat_user) {
            return ['errno'=>1, 'error'=>'缺少参数'];
        }


        if (isset($wecheat_user->user_id) && $wecheat_user->user_id) {
            return ['errno'=>1, 'error'=>'用户已绑定，如需更换，请联系工作人员'];
        }


        $outerTransaction = Yii::$app->db->beginTransaction();
        try{
            $uform = new UserForm();
            $uform->username = $post['uname'];
            $uform->email = $post['email'];
            $uform->password = $post['passwd'];
            $uform->repassword = $post['repasswd'];
            $uform->mobile = $post['mobile'];
            $user = $uform->create();

            $wecheat_user->user_id = $user->id;
            $wecheat_user->save();

            $error='';
            if ($errors = $uform->getErrors()) {
                $error =array_shift($errors);
                $error = $error[0];
            }

            $outerTransaction->commit();

        } catch (\Exception $e) {
            $outerTransaction->rollBack();
            return ['errno'=>1, 'error'=>'账户创建失败 '];

        }

        return true;
    }

    public function actionLogin($code)
    {

        $params = Yii::$app->request->get();

        $app = $this->initMiniProgram();

        $miniProgram = $app->mini_program;

        $data = $miniProgram->sns->getSessionKey($code);
        $openid = $data['openid'];

        $udata = json_decode($params['udata'], true);


        $class = $this->modelClass;

        $umodel = $class::find()->where(['openid'=>$openid, 'type'=>1])->one();
        if (!$umodel) {
            $umodel = new $class;
            $umodel->load($udata, '');
            $umodel->openid = $openid;
            $umodel->type = $umodel::TYPE_MINI;
            $umodel->nickname = $udata['nickName'];
            $umodel->sex = $udata['gender'];
            $umodel->headimgurl = $udata['avatarUrl'];
            $umodel->save();
        }
        return ['umodal'=>$umodel, 'expand'=>['is_staff'=>$umodel->isStaff]];
//        $a = $miniProgram->encryptor->decryptData($data['session_key'], $post['iv'], $post['encryptedData']);
    }

    public function actionUserInfo($id)
    {
        $class = $this->modelClass;
        $uInfo = $class::findOne($id);
        return $uInfo;
    }

    public function actionMiniProgramMobile()
    {
        $post = Yii::$app->request->post();

        $code = $post['code'];
        $iv = $post['iv'];
        $encrypt = $post['encrypt'];

        $app = $this->initMiniProgram();
        $miniProgram = $app->mini_program;
        $sessionKey = $miniProgram->sns->getSessionKey($code);
        return $miniProgram->encryptor->decryptData($sessionKey['session_key'], $iv, $encrypt);
    }

//    public function actionAdd()
//    {
//        $post = Yii::$app->request->post();
//
//        $app = $this->initMiniProgram();
//        $miniProgram = $app->mini_program;
//        $data = $miniProgram->sns->getSessionKey($code);
//
//
//        return $post;
//    }

    /**
     * @name 更新个人信息
     */
    public function actionUpUser()
    {
        $post = Yii::$app->request->post();

        $user = \app\modules\user\models\User::findOne($post['id']);
        $user->email = $post['email'];
        $user->mobile = $post['mobile'];
        return $user->save();
    }

    public function actionGetSysUserInfo($id)
    {
        $user = \app\modules\user\models\User::findOne($id);
        if (!$user) {
            return ['errno'=>1, 'error'=>'不存在此账号'];
        }

        return ['email'=>$user->email, 'mobile'=>$user->mobile,'username'=>$user->username];
    }

}
