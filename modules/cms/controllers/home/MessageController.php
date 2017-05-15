<?php
/**
 * Created by 461915491@qq.com
 * User: wansq
 * Date: 2017/5/15
 * Time: 22:31
 */


namespace app\modules\cms\controllers\home;

use yii;
use app\modules\cms\models\MsgForm;
use app\modules\grave\models\Grave;

class MessageController extends \app\modules\home\controllers\HomeController
{
    public function actionIndex($id)
    {

        $grave = Grave::findOne($id);
        if (!$grave) {
            return $this->error('所选墓区不存在，请重新选择');
        }

        $model = new MsgForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->create()) {
                Yii::$app->session->setFlash('success', '预约服务成功，非常感谢您的关注,我们会尽快联系您');
                return $this->redirect(['/grave/home/default/view', 'id'=>$id]);
            }
        }
        $model->res_name = 'grave';
        $model->res_id = $id;
        $model->title = '我想看看'.$grave->name .'的环境';
        return $this->render('index', ['model'=>$model, 'grave'=>$grave]);
    }
}
