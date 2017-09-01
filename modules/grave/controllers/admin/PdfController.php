<?php

namespace app\modules\grave\controllers\admin;

use yii;
use app\core\web\BackController;
use app\core\libs\Fpdf;
/**
 * BuryController implements the CRUD actions for Bury model.
 */
class PdfController extends BackController
{

    public function actionLong()
    {
        $str = <<<STR
自己编写的PHP按字符串长度分割成数组代码，支持中文字符，下面给出代码和使用方法，有需要的小伙伴可以参考下。
自己编写的PHP按字符串长度分割成数组代码，支持中文字符，下面给出代码和使用方法，有需要的小伙伴可以参考下。
自己编写的PHP按字符串长度分割成数组代码，支持中文字符，下面给出代码和使用方法，有需要的小伙伴可以参考下。
自己编写的PHP按字符串长度分割成数组代码，支持中文字符，下面给出代码和使用方法，有需要的小伙伴可以参考下。
自己编写的PHP按字符串长度分割成数组代码，支持中文字符，下面给出代码和使用方法，有需要的小伙伴可以参考下。
STR;


        $arr = Fpdf::bodyLn($str, 45, [10,50]);


        $pdf = new Fpdf('P','mm','A4');
        $pdf->AddPage();
        $pdf->AddGBFont('simkai','楷体_GB2312'); //这个一定要有，否则无法使用 $pdf->SetFont();


        foreach($arr['content'] as $v){
            $pdf->setXY($v['x'],$v['y']);
            $pdf->SetFont($v['font'],$v['b'],$v['font_size']);
            $pdf->cell(10,10, $v['content']);
        }

        $y = $arr['y'];



        $pdf->addPage();

        $pdf->setXY(10,$y);
        $pdf->cell(10,10, 'hello world');


        $pdf->SetTextColor(0,0,255);
        $pdf->Write(1,'www.fpdf.org','http://www.fpdf.org');

        ob_end_clean();
        $pdf->Output();
    }

    public function actionContent()
    {

        $pdf = new Fpdf('P','mm','A4');
        $pdf->AddPage();
        $pdf->AddGBFont('simkai','楷体_GB2312'); //这个一定要有，否则无法使用 $pdf->SetFont();

        $content = array(
            array("content" => "收款收据（销售）","y" => 10,"x" => 90,"b" => true ,"font_size" => 10),
            array("content" => "日期：","y" => 15,"x" => 49,"b" => false ,"font_size" => 8),

            array("content" => date("Y年m月d日"),"y" => 15,"x" => 58,"b" => false ,"font_size" => 8),
            array("content" => "单据编号：","y" => 15,"x" => 118,"b" => false ,"font_size" => 8),

            array("content" => "交款人","y" => 21,"x" => 35,"b" => false ,"font_size" => 8),

            array("content" => "收款单位","y" => 21,"x" => 91,"b" => false ,"font_size" => 8),
            //收款单位
            array("content" => "仙鹤岭公墓","y" => 20,"x" => 115,"b" => false ,"font_size" => 8),
            array("content" => "收款项目","y" => 21,"x" => 146,"b" => false ,"font_size" => 8),
            //收款项目
            array("content" => "销售","y" => 21,"x" => 171,"b" => false ,"font_size" => 8),

            array("content" => "墓地地址","y" => 28,"x" => 50,"b" => false ,"font_size" => 8),
        );

        $result = Fpdf::content($content);

        foreach($result as $v){
            $pdf->setXY($v['x'],$v['y']);
            $pdf->SetFont($v['font'],$v['b'],$v['font_size']);
            $pdf->cell(10,10, $v['content']);
        }

        $table = [
            [
                [10,10],//起始 x y
                [50,9],//长 高
                [20,9],
                [10,9],
                [60,9]
            ],//第一排
            [
                [10,19],//起始 x y
                [30,9],
                [30,9],
                [50,9]
            ],//第二排
        ];

        $tableArr = Fpdf::table($table, 1, 30);

        foreach ($tableArr as $v){
            $pdf->SetXY($v['x'],$v['y']);
            $pdf->cell($v['w'],$v['h'], '', 1);
        }

        ob_end_clean();
        $pdf->Output();

    }

    public function actionTable()
    {
        $pdf = new Fpdf('P','mm','A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);

        $table = [
            [
                [10,10],//起始 x y
                [50,9],//长 高
                [20,9],
                [10,9],
                [60,9]
            ],//第一排
            [
                [10,19],//起始 x y
                [30,9],
                [30,9],
                [50,9]
            ],//第二排
        ];

        $tableArr = Fpdf::table($table, 1, 30);

        foreach ($tableArr as $v){
            $pdf->SetXY($v['x'],$v['y']);
            $pdf->cell($v['w'],$v['h'], '', 1);
        }

        ob_end_clean();
        $pdf->Output();

    }
}
