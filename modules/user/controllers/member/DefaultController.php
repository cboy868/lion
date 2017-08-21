<?php

namespace app\modules\user\controllers\member;

use yii;
use app\modules\user\models\ForgetForm;
use app\modules\user\models\Token;
use app\modules\user\models\PasswdForm;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use app\modules\user\models\User;

class DefaultController extends \app\core\web\MemberController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['forget', 'confirm', 'token'],
                        'allow' => false,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['forget', 'confirm', 'token'],
                        'allow' => true,
                    ],
                    
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @name 忘记密码页面
     */
    public function actionForget()
    {
        $this->layout = "@app/core/views/layouts/single.php";
        $model = new ForgetForm();
        if ($model->load(Yii::$app->request->post())) {

            if ($model->create()) {
                Yii::$app->getSession()->setFlash('success', '已发送修改密码连接至您的邮箱，请及时修改');
            } else {
                Yii::$app->getSession()->setFlash('error', '邮箱不存在，请重试');
            }

        }
        return $this->render('forget', [
            'model' => $model,
        ]);
    }

    // public function actionSuccess()
    // {
    //     if (Yii::$app->getSession()->hasFlash('success')) {
    //         return $this->render('success');
    //     } else {
    //         return $this->goHome();
    //     }
        
    // }

    /**
     * @name 注册后邮箱确认页面
     */
    public function actionConfirm($code)
    {
        $this->layout = "@app/core/views/layouts/single.php";
        $model = Token::find()->where(['code'=>$code, 'type'=>Token::TYPE_REGISTER])->one();

        if (!$model) {
            throw new NotFoundHttpException('连接不存在或已过期', 1);
        }
        
        $outerTransaction = Yii::$app->db->beginTransaction();

        try {
            $user = User::findOne($model->user_id);

            $user->status = User::STATUS_ACTIVE;
            $user->save();
            $model->type = Token::TYPE_DELETE;
            $model->save();

            $outerTransaction->commit();

            return $this->redirect(['/member/default/login']);
        } catch (\Exception $e) {
            throw new NotFoundHttpException($e->getMessage(), 1);
            $outerTransaction->rollBack();
        }

    }

    /**
     * @name 忘记密码，修改密码页面
     */
    public function actionToken($code)
    {
        $this->layout = "@app/core/views/layouts/single.php";
        $model = Token::find()->where(['code'=>$code, 'type'=>Token::TYPE_RESET])->one();

        //不能为空
        if (!$model) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
        //不可过期
        if ($model->created_at < strtotime('-3 day')) {
            throw new NotFoundHttpException(Yii::t('app', 'Page Expired.'));
        }

        $pwd = new PasswdForm();
        $pwd->setScenario('forget');

        $post = Yii::$app->request->post();
        if ($pwd->load($post)) {
            if ($pwd->forget($model)) {
                $model->type = Token::TYPE_DELETE;
                $model->save();
                Yii::$app->getSession()->setFlash('success', '密码修改成功, 请重新登录');
                return $this->redirect(['/member/login']);
            } else {
                Yii::$app->getSession()->setFlash('error', '密码修改失败');
            }
        }

        return $this->render('token', [
                'pwd'=>$pwd,
                'model'=> $model
            ]);
    }
}
