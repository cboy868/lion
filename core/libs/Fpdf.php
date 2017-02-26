<?php 

namespace app\core\libs;

require(\Yii::getAlias('@app/core/libs/fpdf181/chinese.php'));
use PDF_Chinese;

/**
* 
*/
class Fpdf extends PDF_Chinese
{


 //   $table = [
 //        [
 //            [10,10],//起始 x y
 //            [50,9],//长 高
 //            [20,9],
 //            [10,9],
 //            [60,9]
 //        ],//第一排
 //        [
 //            [10,19],//起始 x y
 //            [30,9],
 //            [30,9],
 //            [50,9]
 //        ],//第二排
 //    ];
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
				'font' => $v['font'] ? $v['font'] : $font
			];
        }

        return $result;
	}



	/**
	 * @name 大段文字换行
	 * @body 内容
	 * @num 每行字数
	 * @start 起始位置
	 * @height 行高
	 * @indent 缩进字数
	 * 
	 */
	public static function bodyLn($body, $num, $start = [10,10], $height = 8, $font_size=12, $b='B', $font="simkai", $indent = 2)
	{

		$params = 
		$data = \app\core\helpers\StringHelper::mbStrSplit($body, $num, $indent);
		$result = [];
		$y = 0;

		foreach ($data as $k => $v) {
			$y = $start[1] + ($height * $k);

			$result[] = [
				'content'=> iconv('UTF-8', 'GBK', $v),
				'x' => $start[0],
				'y' => $start[1] + ($height * $k),
				'b' => $b,
				'font' => $font,
				'font_size' => $font_size
			];
		}

		return ['content'=>$result, 'y'=>$y+$height];
	}
}



