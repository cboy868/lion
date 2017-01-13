<?php

namespace app\modules\user\controllers\member;

use yii;
use app\modules\user\models\ForgetForm;
use app\modules\user\models\Token;
use app\modules\user\models\PasswdForm;
use yii\web\NotFoundHttpException;

class DefaultController extends \app\core\web\MemberController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @name 忘记密码页面
     */
    public function actionForget()
    {
        $model = new ForgetForm();
        if ($model->load(Yii::$app->request->post()) && $model->create()) {
            return $this->goBack();
        } else {
            return $this->render('forget', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @name 注册后邮箱确认页面
     */
    public function actionConfirm()
    {

    }

    /**
     * @name 忘记密码，修改密码页面
     */
    public function actionToken($code)
    {
        $model = Token::find()->where(['code'=>$code, 'type'=>Token::TYPE_RESET])->one();

        //不能为空

        if (!$model) {
            throw new NotFoundHttpException(Yii::t('yii', 'The requested page does not exist.'));
        }
        //不可过期
        if ($model->created_at < strtotime('-3 day')) {
            throw new NotFoundHttpException('页面已过期.');
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
