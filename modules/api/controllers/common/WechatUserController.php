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
class WechatUserController extends Controller
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

        if ($wecheat_user->user_id) {
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

    public function actionLogin($code)
    {

        $options = [
            'mini_program' => [
                'app_id'   => 'wx6b31b3c15e5f1b85',
                'secret'   => '65931a81bde1c9f92e8bd4fea3e5822a',
                'token'    => 'pNxLA9w6dR4D15PbYjnyezSMWriEJvsV',
                'aes_key'  => 'component-aes-key'
            ],
            'debug'  => true,
            'log' => [
                'level'      => 'trace',
                'permission' => 0777,
                'file'       => '/tmp/easywechat.log',
            ]
        ];

        $app = new Application($options);
        $miniProgram = $app->mini_program;


        $data = $miniProgram->sns->getSessionKey($code);

        return $data['openid'];




//        $miniProgram->encryptor->decryptData($sessionKey, $iv, "sRGS9taH/HmYQw2xhXQVddWvFof5QcDiExLCtP8RHmDijo14lf/aLfzDAUKBaFhoBOokaT9FhDyBY3qMkxw7cy1CEbOscSvDI1nDorY4Ea0Q+WwDY2QoMGskeslQ+Sy/TU/MtdbAN05tpMMnjemSOzGbCShmbWIr6RhqR6OmZ2nkN0ujg5AMx8GAMLES+OXzxBoNSpKzFM91ZR1MjtvsVgp2nct01FOYYD1gWPS7vO8gNF5ZbKG+KnHe9hldRdtnSkepaUCfAmYFuz5BcfPUhByPNnLSebYQjmAYvSLtXM/R1F3Y8NwOCjR2J74AqUDKDuzjB3zwh1ETf7JCt+5wbx7kmArYX89tPZrFG84r+ZTbIRAx9IN2yv8lFIIn9SHt1TPtxTO9CgfIPkRwDFW2SOIY6xTyH2gUphCKlZcm9fHMNHMArJ2ModnTkDnX5WhrF1ex8kaHTFt539/yNIyNCA==");


    }

    public function actionAdd()
    {
        $post = Yii::$app->request->post();
        return $post;
    }

}
