<?php

namespace app\modules\admin\controllers;

use app\core\helpers\StringHelper;
use app\modules\admin\models\Pdf;
use app\core\libs\Fpdf;
use app\modules\grave\models\Card;
use app\modules\grave\models\Tomb;
use app\modules\order\models\Order;
use app\modules\order\models\Pay;
use yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\modules\admin\models\LoginForm;
use app\modules\user\models\Log as LoginLog;

class PdfController extends \app\core\web\BackController
{


    /**
     * @param $tomb_id
     * @param $order_id
     * @return string
     * @name 打印各种资料
     */
	public function actionIndex($tomb_id, $order_id)
    {
        return $this->render('index');
    }


    /**
     * @name 打印收款单
     */
    public function actionOrder($order_id=null, $pay_id=null)
    {


        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();


            $pdf = new Fpdf('P','mm','A4');
            $pdf->AddPage();
            $pdf->AddGBFont('simkai','楷体_GB2312');

            $table = $this->dealOrderTable();
            $tableArr = Fpdf::table($table, 1, 20);

            foreach ($tableArr as $v){
                $pdf->SetXY($v['x'],$v['y']);
                $pdf->cell($v['w'],$v['h'], '', 1);
            }

            $result = $this->dealOrderData($post);
            $result = Fpdf::content($result,'simkai', 15, 'B', 1, 20);

            foreach($result as $v){
                $pdf->setXY($v['x'],$v['y']);
                $pdf->SetFont($v['font'],$v['b'],$v['font_size']);
                $pdf->cell(10,10, $v['content']);
            }


            $arr = Fpdf::bodyLn($post['detail'], 60, [10,65], 6, 12);

            foreach($arr['content'] as $v){
                $pdf->setXY($v['x'],$v['y']);
                $pdf->SetFont($v['font'],$v['b'],$v['font_size']);
                $pdf->cell(10,10, $v['content']);
            }

            ob_end_clean();
            $pdf->Output();
        }


        if ($pay_id) {
            $pay = Pay::findOne($pay_id);
            $order = $pay->order;
        }

        if ($order_id) {
            $order = Order::findOne($order_id);
        }
        $orels = $order->rels;

        $model = new Pdf(['pay_id'=>$pay_id, 'order_id'=>$order_id]);



        $info = [
            'tomb_no' => $model->getTombNo(),
            'tomb_price' => $model->getTombPrice(),
            'bury_price' => $model->getBuryPrice(),
            'ins_price'  => $model->getInsPrice(),
            'goods_price'=> $model->getGoodsPrice(),
            'should_pay'      => $model->getShouldPay(),//应付款
            'aready_total'  => $model->getAlreadyPay(),//已付款
            'aready_total_payment' => StringHelper::num2rmb($model->getAlreadyPay()) . '整',
            'this_total' => $model->getAlreadyPay(),
            'this_total_payment' => StringHelper::num2rmb($model->getAlreadyPay()) . '整',
            'guide_name'         => $model->getGuideName(),
            'op_name'       => Yii::$app->user->identity->username,
            'customer_name' => $model->getCustomerName(),
            'pay_time'      => $model->getTime()
        ];

        if ($pay_id) {
            $info['this_total'] = $model->getThisPay();
            $info['this_total_payment'] = StringHelper::num2rmb($model->getThisPay()) . '整';

        }

        $detail = '';
        foreach ($orels as $rel) {
            $detail .= $rel->title .':'. $rel->num . '件,';
        }

        $info['detail'] = $detail;






        return $this->renderAjax('order', [
            'info' => $info
        ]);
    }

    private function dealOrderTable()
    {
        $table = [
            [
                [10,10],//起始 x y
                [35,9],
                [50,9],//长 高
                [35,9],
                [65,9],
            ],//第一排
            [
                [10,19],//起始 x y
                [25,9],
                [35,9],
                [25,9],
                [35,9],
                [25,9],
                [40,9],
            ],//第二排
            [
                [10,28],//起始 x y
                [25,9],
                [35,9],
                [25,9],
                [35,9],
                [25,9],
                [40,9],
            ],//第二排
            [
                [10,37],//起始 x y
                [38,9],
                [95,9],
                [17,9],
                [35,9],
            ],//第二排
            [
                [10,46],//起始 x y
                [185,27],
            ],//第二排

            [
                [10,73],//起始 x y
                [25,9],
                [35,9],
                [25,9],
                [35,9],
                [25,9],
                [40,9],
            ],//第二排
        ];

        return $table;


    }

    private function dealOrderData($info)
    {


        $cfg = [
            'title' => ['content'=>'收 据','x'=>100, 'y'=>-5, 'b'=>true, 'font_size'=>20],
            'customer_label' => ['content'=>'办理人','x'=>10, 'y'=>10, 'b'=>true, 'font_size'=>15],
            'customer_name'  => ['x'=>45, 'y'=>10, 'b'=>true, 'font_size'=>15],
            'tomb_label'     => ['content'=>'位置','x'=>95, 'y'=>10, 'b'=>true, 'font_size'=>15],
            'tomb_no'        => ['x'=>130, 'y'=>10, 'b'=>true, 'font_size'=>15],

            'tprice_label'   => ['content'=>'墓穴费','x'=>10, 'y'=>19, 'b'=>true, 'font_size'=>15],
            'tomb_price'   => ['x'=>35, 'y'=>19, 'b'=>true, 'font_size'=>15],
            'bprice_label'   => ['content'=>'安葬费','x'=>70, 'y'=>19, 'b'=>true, 'font_size'=>15],
            'bury_price'   => ['x'=>95, 'y'=>19, 'b'=>true, 'font_size'=>15],
            'iprice_label'   => ['content'=>'碑文费','x'=>130, 'y'=>19, 'b'=>true, 'font_size'=>15],
            'ins_price'   => ['x'=>155, 'y'=>19, 'b'=>true, 'font_size'=>15],


            'gprice_label'   => ['content'=>'小商品费','x'=>10, 'y'=>28, 'b'=>true, 'font_size'=>15],
            'goods_price'   => ['x'=>35, 'y'=>28, 'b'=>true, 'font_size'=>15],
            'should_pay_label'   => ['content'=>'应付款','x'=>70, 'y'=>28, 'b'=>true, 'font_size'=>15],
            'should_pay'   => ['x'=>95, 'y'=>28, 'b'=>true, 'font_size'=>15],
            'aready_label'   => ['content'=>'已付款','x'=>130, 'y'=>28, 'b'=>true, 'font_size'=>15],
            'aready_total'   => ['x'=>155, 'y'=>28, 'b'=>true, 'font_size'=>15],

            'this_label_paymeht'   => ['content'=>'本次付款(大写)','x'=>10, 'y'=>37, 'b'=>true, 'font_size'=>15],
            'this_total_payment'   => ['x'=>50, 'y'=>37, 'b'=>true, 'font_size'=>15],
            'this_label'   => ['content'=>'小写','x'=>142, 'y'=>37, 'b'=>true, 'font_size'=>15],
            'this_total'   => ['x'=>160, 'y'=>37, 'b'=>true, 'font_size'=>15],

            'guide_label'   => ['content'=>'导购','x'=>10, 'y'=>73, 'b'=>true, 'font_size'=>15],
            'guide_name'   => ['x'=>35, 'y'=>73, 'b'=>true, 'font_size'=>15],
            'op_label'   => ['content'=>'操作员','x'=>70, 'y'=>73, 'b'=>true, 'font_size'=>15],
            'op_name'   => ['x'=>95, 'y'=>73, 'b'=>true, 'font_size'=>15],
            'date_label'   => ['content'=>'日期','x'=>130, 'y'=>73, 'b'=>true, 'font_size'=>15],
            'pay_time'   => ['x'=>155, 'y'=>73, 'b'=>true, 'font_size'=>15],


//            'tomb_no' => $model->getTombNo(),
//            'tomb_price' => $model->getTombPrice(),
//            'bury_price' => $model->getBuryPrice(),
//            'ins_price'  => $model->getInsPrice(),
//            'goods_price'=> $model->getGoodsPrice(),
//            'should_pay'      => $model->getShouldPay(),//应付款
//            'aready_total'  => $model->getAlreadyPay(),//已付款
//            'guide_name'         => $model->getGuideName(),
//            'op_name'       => Yii::$app->user->identity->username,
//            'customer_name' => $model->getCustomerName(),
//            'pay_time'      => $model->getTime()
        ];


        $result = [];
        foreach ($info as $k=>$v) {
            if (!isset($cfg[$k])) continue;
            $result[$k] = [
                'content'=>$v, 'x'=>$cfg[$k]['x'], 'y'=>$cfg[$k]['y'], 'b'=>true, 'font_size'=>15
            ];
        }


        $result = array_merge($cfg, $result);



        return $result;
    }


    public function actionPay($pay_id)
    {

        $model = new Pdf(['pay_id'=>22]);

        $data = [
            'tomb_no'   => $model->getTombNo(),
            'username'  => $model->getUserName(),
            'total'     => $model->getTotal(),
            'tomb_price'=> $model->getTombPrice(),


            'expand'        => 10,
            'burial'        => 10,
            'inscription'   => 10,
            'smallware'     => 10,


            'already_pay'   => $model->getAlreadyPay(),
            'should_pay'    => $model->getShouldPay(),
            'this_pay'      => $model->getThisPay(),
            'this_payment'  => $model->getThisPayment() ,
            'note'          => $model->getNote(),
            'guide_name'    => $model->getGuideName(),
            'op_name'       => $model->getOpName(),
            'time'          => $model->getTime()
        ];

        $maps = Pdf::$field_map;

        $result = [
            ['content'=>$model->getTombNo(), 'x'=>0, 'y'=>0, 'b'=>true, 'font_size'=>10]
        ];

        $pdf = new Fpdf('P','mm','A4');
        $pdf->AddPage();
        $pdf->AddGBFont('simkai','楷体_GB2312'); //这个一定要有，否则无法使用 $pdf->SetFont();


        $result = Fpdf::content($result);

        foreach($result as $v){
            $pdf->setXY($v['x'],$v['y']);
            $pdf->SetFont($v['font'],$v['b'],$v['font_size']);
            $pdf->cell(10,10, $v['content']);
        }

        ob_end_clean();
        $pdf->Output();

    }

}
