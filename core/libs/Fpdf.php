<?php 

namespace app\core\libs;

require(\Yii::getAlias('@app/core/libs/fpdf181/chinese.php'));
use PDF_Chinese;

/**
* 
*/
class Fpdf extends PDF_Chinese
{

	public function test()
	{

		$pdf = new self('P','mm','A4');
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);

		$table = [
			[
				[10,10],//起始 x y
				[20,9],
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

		$tableArr = self::table($table, 1, 30);

    	foreach ($tableArr as $v){
	    	$pdf->SetXY($v['x'],$v['y']);
	    	$pdf->cell($v['w'],$v['h'], '', 1);
	    }

	    ob_end_clean();
	    $pdf->Output();
	}

	

	// $table = [
	// 	[
	// 		[10,10],//起始 x y
	// 		[20,9],
	// 		[20,9],
	// 		[10,9],
	// 		[60,9]
	// 	],//第一排
	// 	[
	// 		[10,19],//起始 x y
	// 		[30,9],
	// 		[30,9],
	// 		[50,9]
	// 	],//第二排
	// ];

	// $pdf = new self('P','mm','A4');
	// $pdf->AddPage();
	// $pdf->SetFont('Arial','B',16);
	// $tableArr = self::table($table, 20, 30);

	// foreach ($tableArr as $v){
 //    	$pdf->SetXY($v['x'],$v['y']);
 //    	$pdf->cell($v['w'],$v['h'], '', 1);
 //    }

    // ob_end_clean();
    // $pdf->Output();

	/**
	 * @name 处理表格
	 * $err_x x方向偏移
	 * $err_y y方向偏移
	 */
	public static function table($table, $err_x=0, $err_y=0)
	{
		if (!is_array($table)) {
			return false;
		}

		$result = [];
		foreach ($table as $k => $v) {
			$start = array_shift($v);
			$start_x = $start[0] + $err_x;
			$start_y = $start[1] + $err_y;

			foreach ($v as $k => $td) {
				$result[] = [
					'x' => $start_x,
					'y' => $start_y,
					'w' => $td[0],
					'h' => $td[1]
				];
				$start_x += $td[0];
			}
		}
		return $result;
	}



// $pdf = new self('P','mm','A4');
// $pdf->AddPage();
// $pdf->AddGBFont('simkai','楷体_GB2312'); 


// foreach($content as $v){
// 	$pdf->setXY($v['x'],$v['y']);
// 	$pdf->SetFont($v['font'],$v['b'],$v['font_size']); 
// 	$pdf->cell(10,10, $v['content']);
// }



// ob_end_clean();
// $pdf->Output();
	public static function content($content, $font='simkai', $font_size=12, $b='B', $err_x=0, $err_y=0)
	{
		$result = [];
		foreach($content as $v){
			$result[] = [
				'b' => isset($v['b']) && $v['b'] ? 'B' : $b,
				'font_size' => isset($v['font_size']) ? $v['font_size'] : $font_size,
				'content' => iconv('UTF-8', 'GBK', $v['content']),
				'x' => $v['x'] + $err_x,
				'y' => $v['y'] + $err_y,
				'font' => $font
			];
        }

        return $result;
	}


}

// $pdf = new Fpdf('P','mm','A4');
// $pdf->AddPage();
// $pdf->SetFont('Arial','B',16);
// $pdf->Cell(40,10,'Hello World!');

// ob_end_clean();
// return $pdf->Output();
