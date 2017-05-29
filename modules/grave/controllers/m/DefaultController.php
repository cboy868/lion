<?php

namespace app\modules\grave\controllers\m;

use app\modules\grave\models\Ins;
use app\modules\grave\models\Order;
use app\modules\grave\models\OrderRel;
use yii\web\NotFoundHttpException;

class DefaultController extends \app\core\web\MController
{
    public $uid=3;

    public function actionIndex()
    {
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

        return $this->render('index', ['ins'=>$result]);
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

    public function actionPortrait()
    {
        return $this->render('confirm');
    }
}
