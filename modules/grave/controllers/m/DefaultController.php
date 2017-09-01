<?php

namespace app\modules\grave\controllers\m;

use app\core\helpers\Url;
use yii;
use app\modules\grave\models\Ins;
use app\modules\grave\models\Order;
use app\modules\grave\models\OrderRel;
use app\modules\grave\models\Tomb;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use app\modules\grave\models\Portrait;
use app\modules\api\models\common\WechatUser;
use app\core\helpers\ArrayHelper;
class DefaultController extends \app\core\web\MController
{
    public $uid;


    public function beforeAction($action)
    {
        if (parent::beforeAction($action)){
            $this->initWechat();
            $session = Yii::$app->getSession();

            $wechat_user = $session->get('wechat.wechat_user');

            $this->wechat_user = WechatUser::findOne($wechat_user->id);


            if (!$this->wechat_user->user_id) {
                return $this->redirect(['/m']);
            }

            $this->uid = $this->wechat_user->user_id;

            if ($session->has('wechat.sys_user')) {
                $this->sys_user = $session->get('wechat.sys_user');
            }
            return true;
        }
    }


    public function actionIndex()
    {
        //碑文
        $ins = Ins::find()->andWhere(['user_id'=>$this->uid])->all();

        $result = [];
        if ($ins) {
            foreach ($ins as $v) {
                $order_rel = OrderRel::findOne($v->order_rel_id);
                $order = $order_rel->order;
                if ($order && $order->progress>=Order::PRO_PAY) {
                    $result[$v->is_confirm][$v['id']] = $v;
                }
            }
        }

        $portrait = Portrait::find()->andWhere(['user_id'=>$this->uid])
                                    ->all();

        $portraits = [];
        if ($portrait) {
            foreach ($portrait as $v) {
                $order = $v->order;
                if ($order && $order->progress >= Order::PRO_PAY) {
                    if ($v->status == Portrait::STATUS_CONFIRM) {
                        $portraits[$v->status][$v->tomb_id][] = $v;
                    } else {
                        $portraits['other'][$v->tomb_id][] = $v;
                    }

                }
            }
        }

        return $this->render('index', ['ins'=>$result, 'portrait'=>$portraits]);
    }

    /**
     * @return string
     * @name 查找待确认的碑文
     * @des 条件
     * 1、订单支付完成
     * 2、碑文未确认
     */
    public function actionIns($id)
    {
        $model = Ins::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('ins', ['model'=>$model]);
    }

    public function actionPortrait($tid)
    {
        $models = Portrait::find()->where(['tomb_id'=>$tid])
//                                 ->andWhere(['status'=>Portrait::STATUS_CONFIRM])
                                 ->all();

        $tomb = Tomb::findOne($tid);

        return $this->render('portrait', ['models'=>$models, 'tomb'=>$tomb]);
    }

    /**
     * @param $id
     * @name 碑文确认
     */
    public function actionConfirmIns()
    {
        $id = \Yii::$app->request->post('id');

        $model = Ins::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->confirm($this->uid)) {
            return $this->json();
        }

        return $this->json(null, '碑文确认失败,请及时联系工作人员', 0);
    }

    /**
     * @param $id
     * @name 瓷像确认
     */
    public function actionConfirmPortrait()
    {
        $id = \Yii::$app->request->post('id');


        $portrait = Portrait::find()->where(['status'=>Portrait::STATUS_CONFIRM])
                                ->andWhere(['tomb_id'=>$id])
                                ->all();

        if (!$portrait) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $outerTransaction = Yii::$app->db->beginTransaction();

        try {
            if ($portrait) {
                foreach ($portrait as $v) {
                    $order = $v->order;
                    if ($order && $order->progress >= Order::PRO_PAY) {
                        $v->confirm();
                    }
                }
            }
            $outerTransaction->commit();
        } catch (\Exception $e) {
            $outerTransaction->rollBack();
            return $this->json(null, '瓷确认失败,请及时联系工作人员', 0);
        }

        return $this->json();

    }

    /**
     * @name 墓位档案
     */
    public function actionTombs()
    {
        $query = Tomb::find()->where(['user_id'=>$this->uid]);


        p($query->count());die;
        if ($query->count() == 0) {

            echo Url::toRoute(['/m/user','wid'=>$this->wid]);
            die;
            return $this->redirect(['/m/user','wid'=>$this->wid]);
        }

        if ($query->count() == 1) {
            $model = $query->one();
            return $this->redirect(['tomb', 'id'=>$model->id, 'wid'=>$this->wid]);
        }

        return $this->render('tombs',[
            'wechat' => ArrayHelper::toArray($this->wechat_user)
        ]);
    }

    public function actionTomb($id)
    {
        $model = $this->findTomb($id);

        return $this->render('tomb', [
            'tomb' => $model
        ]);
    }

    /**
     * @param $id
     * @return string|yii\web\Response
     * @name 墓位续费
     */
    public function actionRenew()
    {
        return $this->render('renew', [
            'wechat' => ArrayHelper::toArray($this->wechat_user)
        ]);
    }

    /**
     * @name 碑文修金箔
     */
    public function actionRepair($id=1)
    {
        return $this->render('repair');

//        if (!$model->ins) {
//            return $this->error('此墓位不存在碑文，请先完善或走特殊业务');
//        }
//
//        $config = Yii::$app->params['goods'];
//
//
//        $fee = $this->module->params['ins']['fee']['repair'];
//        $paint = $this->module->params['ins']['paint'];
//        $gid = $config['id']['repair'];
//        $goods = Goods::createVirtual($gid['id'], $gid['name']);
//
//        if (Yii::$app->request->isPost) {
//            $post = Yii::$app->request->post();
//
//            $extra = [
//                'price' => $post['num'] * $fee[$post['paint']],
//                'num'   => $post['num'],
//                'tid'   => $model->id,
//                'note'  => $post['des']
//            ];
//            $info = $goods->order($model->user_id, $extra);
//            if ($info['order']) {
//                return $this->redirect(['/order/admin/default/view', 'id'=>$info['order']->id]);
//            }
//        }
//
//        return $this->render('repair',['model'=>$model, 'fee'=>$fee,'paint'=>$paint]);
    }

    protected function findTomb($id)
    {
        if (($model = Tomb::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
