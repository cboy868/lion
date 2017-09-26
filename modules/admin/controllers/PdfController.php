<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\Pdf;
use app\core\libs\Fpdf;
use app\modules\grave\models\Tomb;
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
