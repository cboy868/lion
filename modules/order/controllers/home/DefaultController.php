<?php

namespace app\modules\order\controllers\home;


use yii;
use app\modules\shop\models\Gooods;
use app\modules\shop\models\Sku;
use app\modules\order\models\Order;
use app\modules\order\models\Pay;
use app\core\libs\Fpdf;


class DefaultController extends \app\core\web\HomeController
{
    public function actionIndex()
    {


    	// $pdf = new Fpdf('P','mm','A4');
     //    $pdf->test();
  //   	$pdf->AddPage();
		// $pdf->SetFont('Arial','B',16);
		// $pdf->Cell(40,10,'Hello World!');

		// ob_end_clean();
  //       // header("Content-type: application/pdf");
  //       // header("Content-Disposition: inline; filename=list.pdf");
		// $pdf->Output();

    	$sku = Sku::findOne(37);
    	$a = $sku->order(16, ['order_note'=> '最新订单', 'note'=>'note记录', 'use_time'=>'2016-02-02 22:12:00', 'num'=>10]);

    	// $order = Order::findOne(5);
    	// Pay::pay($order, Pay::METHOS_CASH, 360);

     //    return $this->render('index');
    }
}
