<?php 

namespace app\core\libs;

require(\Yii::getAlias('@app/core/libs/PHPExcel-1.8/Classes/PHPExcel.php'));

use yii\base\InvalidConfigException;
use yii\grid\SerialColumn;
use yii;
use yii\i18n\Formatter;
use PHPExcel_Style_Fill;
use PHPExcel_Style_Alignment;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQueryInterface;
use yii\data\ArrayDataProvider;
use yii\base\Model;
use yii\helpers\Inflector;
use yii\grid\DataColumn;

/**
* 
*/
class Export extends \PHPExcel
{

    protected $_endRow = 1;

    protected $_endCol = 1;

    protected $_groupedRow = null;

    protected $_dataProvider;

    protected $_provider;

    protected $_objPHPExcelSheet;

    protected $_objPHPExcel;

    public $enableFormatter = true;

    public $columns = [];

    protected $_groupedColumn = [];

    protected $_beginRow = 1;

    public $formatter;

    public $batchSize = 200;

    public $label;

    public $pageTitle;

    public $groupedRowStyle = [
        'font' => [
            'bold' => false,
            'color' => [
                'argb' => '000000',
            ],
        ],
        'fill' => [
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => [
                'argb' => 'C9C9C9',
            ],
        ],
    ];

    /**
     * @name 导出
     */
    public static function export($dataProvider, $columns, $options)
    {
        $objPHPExcel = new self();
        $objPHPExcel->initFormater();

        $objPHPExcel->_dataProvider = $dataProvider;
        $objPHPExcel->columns = $columns;
        $objPHPExcel->pageTitle = isset($options['pageTitle']) ? $options['pageTitle'] : '卓迅数据';

        $objPHPExcel->initExport();
        $objPHPExcel->initColumns();

        $objPHPExcel->initPHPExcel($options);
        $objPHPExcel->initPHPExcelSheet();

        $objPHPExcel->generateBody();

        $objPHPExcel->initHearders($options);
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;

    }

    public function initFormater()
    {
        if ($this->formatter === null) {
            $this->formatter = Yii::$app->getFormatter();
        } elseif (is_array($this->formatter)) {
            $this->formatter = Yii::createObject($this->formatter);
        }
        $this->formatter->nullDisplay = '';
        if (!$this->formatter instanceof Formatter) {
            throw new InvalidConfigException('The "formatter" property must be either a Format object or a configuration array.');
        }
    }

    public function initExport()
    {
        $this->_provider = clone($this->_dataProvider);

        if ($this->batchSize && $this->_provider->pagination) {
            /** @noinspection PhpUndefinedFieldInspection */
            $this->_provider->pagination = clone($this->_dataProvider->pagination);
            $this->_provider->pagination->pageSize = $this->batchSize;
        } else {
            $this->_provider->pagination = false;
        }

    }

    public function initPHPExcel($options)
    {
        $manager = '卓迅数据管理';
        $creator = '卓迅公墓管理系统';
        $title = isset($options['title']) ? $options['title'] : '卓迅数据';
        $subject = isset($options['subject']) ? $options['subject'] : '卓迅数据';
        $category = $keywords = '卓迅';

        $description = 'This document for Office 2007 XLSX, generated using PHP by zhuo-xun.com';
        $company = '卓迅网络';
        $created = date('Y-m-d H:i:s');
        $lastModifiedBy = '卓迅公墓管理系统';
        $properties = $this->getProperties();
        $properties->setCreator($creator)
            ->setTitle($title)
            ->setSubject($subject)
            ->setDescription($description)
            ->setCategory($category)
            ->setKeywords($keywords)
            ->setManager($manager)
            ->setCompany($company)
            ->setCreated($created)
            ->setLastModifiedBy($lastModifiedBy);

        $this->getActiveSheet()->setTitle($title);
    }

    public function generateBody()
    {
        $this->_endRow = 0;
        $this->generateHeaderRow();
        $this->generateHeaderLabel();


        $columns = $this->columns;
        $models = array_values($this->_provider->getModels());
        if (count($columns) == 0) {
            $cell = $this->_objPHPExcelSheet->setCellValue('A1', $this->emptyText, true);
            $model = reset($models);
            return 0;
        }
        // do not execute multiple COUNT(*) queries
        $totalCount = $this->_provider->getTotalCount();
        $this->findGroupedColumn();


        while (count($models) > 0) {

            $keys = $this->_provider->getKeys();
            foreach ($models as $index => $model) {
                $key = $keys[$index];

                $this->generateRow($model, $key, $this->_endRow);

                $this->_endRow++;
                if ($index === $totalCount) {
                    //a little hack to generate last grouped footer
                    $this->checkGroupedRow($model, $models[0], $key, $this->_endRow);
                } elseif (isset($models[$index + 1])) {
                    $this->checkGroupedRow($model, $models[$index + 1], $key, $this->_endRow);
                }
                if (!is_null($this->_groupedRow)) {
                    $this->_endRow++;
                    $this->_objPHPExcelSheet->fromArray($this->_groupedRow, null, 'A' . ($this->_endRow + 1), true);
                    $cell = 'A' . ($this->_endRow + 1) . ':' . self::columnName(count($columns)) . ($this->_endRow + 1);
                    $this->_objPHPExcelSheet->getStyle($cell)->applyFromArray($this->groupedRowStyle);
                    $this->_groupedRow = null;
                }
            }
            break;//如果不加这个，数据全部导出时，数据量可能过大，会崩溃
            if ($this->_provider->pagination) {
                $this->_provider->pagination->page++;
                $this->_provider->refresh();
                $this->_provider->setTotalCount($totalCount);
                $models = $this->_provider->getModels();
            } else {
                $models = [];
            }
        }

        // Set autofilter on
//        $this->_objPHPExcelSheet->setAutoFilter(
//            self::columnName(2) . $this->_beginRow . ':' . self::columnName($this->_endCol) . $this->_endRow
//        );
        return $this->_endRow;
    }

    public function generateHeaderRow()
    {

        $colFirst = self::columnName(1);
        $col_num = count($this->columns);
        $colEnd = self::columnName($col_num);

        $this->_endRow++;
        $this->_objPHPExcelSheet->mergeCells($colFirst. $this->_endRow++.':' . $colEnd . $this->_endRow++);

        // 2 字段头部设置
        $header_style = array(
            'font' => array(
                'size' =>13,
                'color' => array('argb' => 'FFFFFFCC')
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('argb' => 'FF336699')
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );

        $this->_objPHPExcelSheet->getStyle('A1')->applyFromArray($header_style);

        $this->_objPHPExcelSheet->setCellValue(
            'A1',
            $this->pageTitle,
            true
        );

    }

    public function generateHeaderLabel()
    {
        $this->_endCol = 0;
        foreach ($this->columns as $k => $column) {
            $label = $this->getHeaderCellLabel($column);

            $this->_endCol++;
            $this->_objPHPExcelSheet->setCellValue(
                self::columnName($this->_endCol) . ($this->_endRow),
                !isset($label) || $label === '' ? '' : strip_tags($label),
                true
            );
        }
        $this->_endRow++;

    }

    protected function getHeaderCellLabel($column)
    {
        $provider = $this->_provider;

        if ($column->label === null) {
            if ($provider instanceof ActiveDataProvider && $provider->query instanceof ActiveQueryInterface) {
                /* @var $model Model */
                $model = new $provider->query->modelClass;
                $label = $model->getAttributeLabel($column->attribute);
            } elseif ($provider instanceof ArrayDataProvider && $provider->modelClass !== null) {
                /* @var $model Model */
                $model = new $provider->modelClass;
                $label = $model->getAttributeLabel($column->attribute);
            }  else {
                $models = $provider->getModels();
                if (($model = reset($models)) instanceof Model) {
                    /* @var $model Model */
                    $label = $model->getAttributeLabel($column->attribute);
                } else {
                    $label = Inflector::camel2words($column->attribute);
                }
            }
        } else {
            $label = $column->label;
        }

        return $label;
    }

    public function generateRow($model, $key, $index)
    {
        /**
         * @var Column $column
         */
        $this->_endCol = 0;
        foreach ($this->columns as $column) {
            if ($column instanceof SerialColumn) {
                $value = $column->renderDataCell($model, $key, $index);
            } elseif ($column instanceof ActionColumn) {
                $value = null;
            } elseif (!isset($column->content)) {
                $format = $this->enableFormatter && isset($column->format) ? $column->format : 'raw';
                $value = method_exists($column, 'getDataCellValue') ?
                    $this->formatter->format($column->getDataCellValue($model, $key, $index), $format) :
                    $column->renderDataCell($model, $key, $index);
            } elseif (is_callable($column->content)) {
                $value = call_user_func($column->content, $model, $key, $index, $column);
            } elseif (isset($column->attribute)) {
                $value = ArrayHelper::getValue($model, $column->attribute, '');
            } else {
                $value = null;
            }


            $this->_endCol++;
            $this->_objPHPExcelSheet->setCellValue(
                self::columnName($this->_endCol) . ($index),
                !isset($value) || $value === '' ? '' : strip_tags($value),
                true
            );
        }
    }





    protected function findGroupedColumn()
    {
        foreach ($this->columns as $key => $column) {
            if (isset($column->group) && $column->group == true) {
                $this->_groupedColumn[$key] = ['firstLine' => -1, 'value' => null];
            } else {
                $this->_groupedColumn[$key] = null;
            }
        }
        $this->_groupedColumn[] = null; //prevent the overflow
        $this->_groupedColumn[] = null; //prevent the overflow
    }


    public static function columnName($index)
    {
        $i = intval($index) - 1;
        if ($i >= 0 && $i < 26) {
            return chr(ord('A') + $i);
        }
        if ($i > 25) {
            return (self::columnName($i / 26)) . (self::columnName($i % 26 + 1));
        }
        return 'A';
    }

    public function initPHPExcelSheet()
    {
        $this->_objPHPExcelSheet = $this->getActiveSheet();
    }


    protected function generateGroupedRow($groupFooter, $groupedCol)
    {
        $endGroupedCol = 0;
        $this->_groupedRow = [];
        $fLine = ArrayHelper::getValue($this->_groupedColumn[$groupedCol], 'firstLine', -1);
        $fLine = ($fLine == $this->_beginRow) ? $this->_beginRow + 1 : ($fLine + 3);
        $firstLine = ($this->_endRow == ($this->_beginRow + 3) && $fLine == 2) ? $this->_beginRow + 3 : $fLine;
        $endLine = $this->_endRow + 1;
        list($endLine, $firstLine) = ($endLine > $firstLine) ? [$endLine, $firstLine] : [$firstLine, $endLine];
        foreach ($this->columns as $key => $column) {
            $value = isset($groupFooter[$key]) ? $groupFooter[$key] : '';
            $endGroupedCol++;
            $groupedRange = self::columnName($key + 1) . $firstLine . ':' . self::columnName($key + 1) . $endLine;
            //$lastCell = self::columnName($key + 1) . $endLine - 1;
            if (isset($column->group) && $column->group) {
                $this->_objPHPExcelSheet->mergeCells($groupedRange);
            }
            switch ($value) {
                case self::F_SUM:
                    $value = "=sum($groupedRange)";
                    break;
                case self::F_COUNT:
                    $value = '=countif(' . $groupedRange . ',"*")';
                    break;
                case self::F_AVG:
                    $value = "=AVERAGE($groupedRange)";
                    break;
                case self::F_MAX:
                    $value = "=max($groupedRange)";
                    break;
                case self::F_MIN:
                    $value = "=min($groupedRange)";
                    break;
            }
            if ($value instanceof \Closure) {
                $value = call_user_func($value, $groupedRange, $this);
            }
            $this->_groupedRow[] = !isset($value) || $value === '' ? '' : strip_tags($value);
        }
    }

    protected function checkGroupedRow($model, $nextModel, $key, $index)
    {
        $endCol = 0;
        foreach ($this->columns as $column) {
            /**
             * @var Column $column
             */
            $value = ($column->content === null) ? (method_exists($column, 'getDataCellValue') ?
                $this->formatter->format($column->getDataCellValue($model, $key, $index), 'raw') :
                $column->renderDataCell($model, $key, $index)) :
                call_user_func($column->content, $model, $key, $index, $column);
            $nextValue = ($column->content === null) ? (method_exists($column, 'getDataCellValue') ?
                $this->formatter->format($column->getDataCellValue($nextModel, $key, $index), 'raw') :
                $column->renderDataCell($nextModel, $key, $index)) :
                call_user_func($column->content, $nextModel, $key, $index, $column);
            if ((isset($this->_groupedColumn[$endCol])) && (!is_null($this->_groupedColumn[$endCol]))) {
                if (is_null($this->_groupedColumn[$endCol]['value'])) {
                    $this->_groupedColumn[$endCol]['value'] = $value;
                    $this->_groupedColumn[$endCol]['firstLine'] = $index;
                }
                if ($this->_groupedColumn[$endCol]['value'] != $nextValue) {
                    $groupFooter = isset($column->groupFooter) ? $column->groupFooter : null;
                    if ($groupFooter instanceof Closure) {
                        $groupFooter = call_user_func($groupFooter, $model, $key, $index, $this);
                    }
                    if (isset($groupFooter['content'])) {
                        $this->generateGroupedRow($groupFooter['content'], $endCol);
                    }
                    $this->_groupedColumn[$endCol]['firstLine'] = $index;
                }
                $this->_groupedColumn[$endCol]['value'] = $nextValue;
            }
            $endCol++;
        }
    }

//    public function getVisibleColumns()
//    {
//        $models = $this->_dataProvider->getModels();
//        $model = reset($models);
//        if (is_array($model) || is_object($model)) {
//            foreach ($model as $name => $value) {
//                if ($value === null || is_scalar($value) || is_callable([$value, '__toString'])) {
//                    $this->columns[] = (string) $name;
//                }
//            }
//        }
//
//        return $this->columns;
//    }


    protected function initColumns()
    {
        foreach ($this->columns as $i => $column) {
            if (is_string($column)) {
                $column = $this->createDataColumn($column);
            } else {
                $column = \Yii::createObject(array_merge([
                    'class' => DataColumn::className(),
                    'grid' => $this,
                ], $column));
            }
            if (!$column->visible) {
                unset($this->columns[$i]);
                continue;
            }
            $this->columns[$i] = $column;
        }
    }

    protected function createDataColumn($text)
    {
        if (!preg_match('/^([^:]+)(:(\w*))?(:(.*))?$/', $text, $matches)) {
            throw new InvalidConfigException('The column must be specified in the format of "attribute", "attribute:format" or "attribute:format:label"');
        }

        return \Yii::createObject([
            'class' => DataColumn::className(),
            'grid' => $this,
            'attribute' => $matches[1],
            'format' => isset($matches[3]) ? $matches[3] : 'text',
            'label' => isset($matches[5]) ? $matches[5] : null,
        ]);
    }








    public function initHearders($options)
    {
        $filename = isset($options['filename']) ? $options['filename'] : 'export';
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        ob_end_clean();
    }




    public function renderExcelBody($dataProvider)
    {
        $models = array_values($this->dataProvider->getModels());
        $keys = $this->dataProvider->getKeys();
        $rows = [];
        foreach ($models as $index => $model) {
            $key = $keys[$index];
            if ($this->beforeRow !== null) {
                $row = call_user_func($this->beforeRow, $model, $key, $index, $this);
                if (!empty($row)) {
                    $rows[] = $row;
                }
            }

            $rows[] = $this->renderTableRow($model, $key, $index);

            if ($this->afterRow !== null) {
                $row = call_user_func($this->afterRow, $model, $key, $index, $this);
                if (!empty($row)) {
                    $rows[] = $row;
                }
            }
        }

        if (empty($rows) && $this->emptyText !== false) {
            $colspan = count($this->columns);

            return "<tbody>\n<tr><td colspan=\"$colspan\">" . $this->renderEmpty() . "</td></tr>\n</tbody>";
        } else {
            return "<tbody>\n" . implode("\n", $rows) . "\n</tbody>";
        }
    }
	/**
	 * @name 导出
	 */
	public static function exportbak()
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


//	public static function exportDataProvider($dataProvider, $title=null)
//    {
//
//        $models = $dataProvider->getModels();
//        if (!$models) return ;
//
//        $objPHPExcel = new PHPExcel();
//
//        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
//            ->setLastModifiedBy("Maarten Balliauw")
//            ->setTitle("Office 2007 XLSX Test Document")
//            ->setSubject("Office 2007 XLSX Test Document")
//            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
//            ->setKeywords("office 2007 openxml php")
//            ->setCategory("Test result file");
//
//
//        foreach ($models as $k => $v) {
//            $objPHPExcel->setActiveSheetIndex(0)
//                ->setCellValue('A1', 'Hello');
//        }
//
//
//
//
//    }

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
