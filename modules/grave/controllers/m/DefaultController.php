<?php

namespace app\modules\grave\controllers\m;

use yii;
use app\modules\grave\models\Ins;
use app\modules\grave\models\Order;
use app\modules\grave\models\OrderRel;
use app\modules\grave\models\Tomb;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use app\modules\grave\models\Portrait;

class DefaultController extends \app\core\web\MController
{
    public $uid=3;

    public function actionIndex()
    {
        //碑文
        $ins = Ins::find()->where(['is_confirm'=>0])
                ->andWhere(['user_id'=>$this->uid])
                ->all();

        $result = [];
        if ($ins) {
            foreach ($ins as $v) {
                $order_rel = OrderRel::findOne($v->order_rel_id);
                $order = $order_rel->order;
                if ($order && $order->progress>=Order::PRO_PAY) {
                    array_push($result, $v);
                }
            }
        }

        $portrait = Portrait::find()->where(['status'=>Portrait::STATUS_CONFIRM])
                                    ->andWhere(['user_id'=>$this->uid])
                                    ->all();

        $portraits = [];
        if ($portrait) {
            foreach ($portrait as $v) {
                $order = $v->order;
                if ($order && $order->progress >= Order::PRO_PAY) {
                    $portraits[$v->tomb_id][] = $v;
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
        } catch (Exception $e) {
            $outerTransaction->rollBack();
            return $this->json(null, '瓷确认失败,请及时联系工作人员', 0);
        }

        return $this->json();

    }


}
