<?php 

namespace app\core\libs;

require(\Yii::getAlias('@app/core/libs/PHPExcel-1.8/Classes/PHPExcel.php'));

/**
* 
*/
class PHPExcel extends \PHPExcel
{



	/**
	 * @name 导出
	 */
	public static function export()
	{
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");

		// Add some data
		$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A1', 'Hello')
		            ->setCellValue('B2', 'world!')
		            ->setCellValue('C1', 'Hello')
		            ->setCellValue('D2', 'world!');

		// Miscellaneous glyphs, UTF-8
		$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A4', 'Miscellaneous glyphs')
		            ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');

		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('Simple');


		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="01simple.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		ob_end_clean();

		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;

	}

	/**
	 * @name 导入
	 */
	public static function import($excel_file)
	{



		$reader = \PHPExcel_IOFactory::createReader('Excel2007'); //设置以Excel5格式(Excel97-2003工作簿)
//		$PHPExcel = $reader->load(\Yii::getALias('@app/core/libs/01simple.xlsx')); // 载入excel文件

        $PHPExcel = $reader->load($excel_file);
		foreach($PHPExcel->getWorksheetIterator() as $sheet)  //循环读取sheet
		 {

		 	echo '<hr>';
		 	echo $sheet->getTitle();
			echo '<table>';

		     foreach($sheet->getRowIterator() as $row)  //逐行处理
		     {


		     	echo "<tr>";
		         foreach($row->getCellIterator() as $cell)  //逐列读取
		         {
		             $data = $cell->getValue(); //获取cell中数据
		             echo "<td>";
		             echo $data;
		             echo "</td>";
		         }
		         echo '</tr>';
		     }
			echo "</table>";

		 }
	}
}
