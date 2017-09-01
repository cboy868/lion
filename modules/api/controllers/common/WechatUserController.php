<?php
namespace app\modules\api\controllers\common;

use Yii;
use app\modules\api\models\common\UserForm;
use app\modules\api\models\common\WechatUser;
use app\modules\api\models\common\User;
use EasyWeChat\Foundation\Application;
/**
 * Site controller
 */
class WechatUserController extends WechatController
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



    public function actionBind()
    {
        $post = Yii::$app->request->post();

        $user = User::findByUsername($post['uname']);

        if (!$user) {
            return ['errno'=>1, 'error'=>'用户名或密码不正确，请重试'];
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

        if (isset($wecheat_user->user_id)) {
            return ['errno'=>1, 'error'=>'用户已绑定，如需更换，请联系工作人员'];
        }

        $uform = new UserForm();
        $uform->username = $post['uname'];
        $uform->email = $post['email'];
        $uform->password = $post['passwd'];
        $uform->repassword = $post['repasswd'];

        if($user = $uform->create()) {
            $wecheat_user->user_id = $user->id;
            $wecheat_user->save();
            return true;
        }

        $error='';
        if ($errors = $uform->getErrors()) {
            $error =array_shift($errors);
            $error = $error[0];
        }

        return ['errno'=>1, 'error'=>'账户创建失败 '.$error];

    }

    public function actionMiniProLogin($code)
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

        return $umodel;


//        $a = $miniProgram->encryptor->decryptData($data['session_key'], $post['iv'], $post['encryptedData']);


    }


    public function actionAdd()
    {
        $post = Yii::$app->request->post();

        $app = $this->initMiniProgram();
        $miniProgram = $app->mini_program;
        $data = $miniProgram->sns->getSessionKey($code);


        return $post;
    }



}
