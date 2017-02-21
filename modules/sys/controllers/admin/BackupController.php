<?php

namespace app\modules\sys\controllers\admin;

use Yii;
use yii\web\Controller;
use spanjeta\modules\backup\models\UploadForm;
use yii\data\ArrayDataProvider;
use yii\web\HttpException;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

class BackupController extends \app\core\web\BackController {


	public $menu = [];

	public $tables = [];

	public $fp;

	public $file_name;

	public $enableZip = true;

	public $back_file = 'backup_';

	const LINE = '-- -------------------------------------------';

	/**
	 * @name 备份列表
	 */
	public function actionIndex() {

		$list = array_merge($this->getFileList(), $this->getFileList('*.zip'));

		$path = $this->getPath();
		$columns = [];
		foreach ($list as $id => $fname) {
			$columns[$id] = [
				'id' => $id,
				'name' => basename($fname),
				'size' => $this->getSize($path . $fname, 'kb'),
				'create_time' => date('Y-m-d H:i:s', filectime($path . $fname)),
				'modified_time' => date('Y-m-d H:i:s', filemtime($path . $fname)),
			];
			// if (date ( 'M-d-Y' . ' \a\t ' . ' g:i A', filemtime($path . $fname)) > date('M-d-Y' . ' \a\t ' . ' g:i A', filectime($path . $fname))) {
			// 	$columns[$id]['modified_time'] = date ( 'M-d-Y' . ' \a\t ' . ' g:i A', filemtime ( $path . $fname ) );
			// }
		}

		$dataProvider = new ArrayDataProvider([
			'allModels' => array_reverse($columns),
			'sort' => [
				'attributes' => [
					'modified_time' => SORT_ASC
				]
			]
		]);

		return $this->render('index', [
				'dataProvider' => $dataProvider
			]);
		
	}

	/**
	 * @name 添加备份 
	 */
	public function actionCreate() {

		$tables = Yii::$app->db->createCommand('SHOW TABLES')->queryColumn();

		if (!$this->StartBackup()) {
			Yii::$app->session->setFlash('success', "Error");
			return $this->render('index');
		}
		
		foreach($tables as $tableName){
			$this->getColumns($tableName);
		}

		foreach($tables as $tableName) {
			$this->getData($tableName);
		}
		
		$this->EndBackup();

		Yii::$app->session->setFlash('success', "数据备份成功");

		$this->redirect(['index']);
	}

	/**
	 * @name 清空数据库
	 */
	public function actionClean($redirect = true) {

		$tables = Yii::$app->db->createCommand('SHOW TABLES')->queryColumn();
		
		if (!$this->StartBackup()){
			Yii::$app->session->setFlash('success', "Error");
			return $this->render('index');
		}


		$message = '';
		foreach ($tables as $table) {

			$this->writeLine(self::LINE);
			$this->writeLine('DROP TABLE IF EXISTS ' . addslashes($table) . ';');
			$this->writeLine(self::LINE);

			$message .= $table . ',';
		}

		$this->enableZip = false;
		$this->EndBackup();
		
		Yii::$app->user->logout();
		
		$this->execSqlFile($this->file_name);

		unlink($this->file_name);

		$message .= ' are deleted.';
		Yii::$app->session->setFlash ( 'success', $message );

		return $this->redirect(['index']);
	}


	/**
	 * @name 删除备份文件
	 */
	public function actionDelete($file) {

		$list = array_merge($this->getFileList(), $this->getFileList('*.zip'));
		$list = array_reverse($list);

		$sqlFile = $this->getPath() . basename($file);

		try {
			@unlink($sqlFile);
		} catch (\Exception $e) {
			throw new \HttpException(404, $e->getMessage());
		}

		return $this->redirect(['index']);
	}


	/**
	 * @name 下载备份文件
	 */
	public function actionDownload($filename) {
		$sqlFile = $this->getPath() . basename($filename);

		if (file_exists($sqlFile)) {
			return Yii::$app->getResponse()->sendFile($sqlFile, $filename);
		}
	}


	/**
	 * @name 数据恢复 
	 */
	public function actionRestore($filename) {
		$message = 'OK. Done';

		$sqlZipFile = $this->getPath() . basename ( $filename );
		$sqlFile = $this->unzip($sqlZipFile);

		if (!$sqlFile) {
			return $this->redirect(['index']);
		}

		$status = $this->execSqlFile($sqlFile);
		if ($status == 'ok') {
			Yii::$app->session->setFlash('success', '备份数据导入成功...');
			return $this->redirect(['index']);
		} else {
			Yii::$app->session->setFlash ( 'error', '备份数据导入失败...');
		}
		return $this->render ( 'restore', array (
				'error' => $message 
		) );
	}

	/**
	 * @name 上传备份文件
	 */
	public function actionUpload() {
		$model = new UploadForm ();
		if (isset ( $_POST ['UploadForm'] )) {
			$model->attributes = $_POST ['UploadForm'];
			$model->upload_file = \yii\web\UploadedFile::getInstance ( $model, 'upload_file' );
			if ($model->upload_file->saveAs ( $this->getPath() . $model->upload_file )) {
				// redirect to success page
				return $this->redirect ( array (
						'index' 
				) );
			}
		}
		
		return $this->render ( 'upload', array (
				'model' => $model 
		) );
	}



	public static function parseSql($sql)
    {
        $sql = preg_replace("/TYPE=(InnoDB|MyISAM|MEMORY)( DEFAULT CHARSET=[^; ]+)?/", "ENGINE=\\1 DEFAULT CHARSET=UTF8", $sql);
        $sql = str_replace("\r", "\n", $sql);
        $ret = array();
        $num = 0;
        $queriesarray = explode(";\n", trim($sql));
        unset($sql);
        foreach ($queriesarray as $query)
        {
            $ret[$num] = '';
            $queries = explode("\n", trim($query));
            $queries = array_filter($queries);
            foreach ($queries as $query)
            {
                $str1 = substr($query, 0, 1);
                if ($str1 != '#' && $str1 != '-')
                    $ret[$num] .= $query;
            }
            $num ++;
        }
        return ($ret);
    }

	/**
	 * @name 取结构
	 */
	private function getColumns($tableName) {

		$sql = 'SHOW CREATE TABLE `' . $tableName . '`';

		$table = Yii::$app->db->createCommand($sql)->queryOne();

		$create_query = $table['Create Table'] . ';';
		
		$create_query = preg_replace('/^CREATE TABLE/', 'CREATE TABLE IF NOT EXISTS', $create_query);
		$create_query = preg_replace('/AUTO_INCREMENT\s*=\s*([0-9])+/', '', $create_query);

		if ($this->fp) {
			$this->writeComment('TABLE `' . addslashes($tableName ) . '`');
			$final = 'DROP TABLE IF EXISTS `' . addslashes($tableName ) . '`;' . PHP_EOL . $create_query . PHP_EOL . PHP_EOL;
			fwrite ( $this->fp, $final );
		} else {
			$this->tables [$tableName] ['create'] = $create_query;
			return $create_query;
		}
	}


	/**
	 * @name 取数据
	 */
	private function getData($tableName) {

		$dataReader = Yii::$app->db->createCommand('SELECT * FROM `' . $tableName .'`')->query();
		
		if ($this->fp) {
			$this->writeComment ( 'TABLE DATA ' . $tableName );
		}

		foreach ($dataReader as $v) {
			$instert = '';

			$itemNames = array_map('addslashes', array_keys($v));


			$items = join('`,`', $itemNames);

			$itemValues = array_map('addslashes', array_values($v));

			foreach ($itemValues as $k => &$v) {
				if ($v == null) {
					$v = 'null';
				}
			}unset($v);

			$values = "\n('" . join("','", $itemValues). "'),";
			$values = str_replace('\'null\'', 'null', $values);

			if ($values != '') {
				$instert .= "INSERT INTO `$tableName` (`$items`) VALUES" . rtrim ( $values, "," ) . ";;;" . PHP_EOL;
			}

			if ($this->fp) {
				fwrite($this->fp, $instert);
			}

		}
		
		if ($this->fp) {
			$this->writeComment('TABLE DATA ' . $tableName);
			$final = PHP_EOL . PHP_EOL . PHP_EOL;
			fwrite($this->fp, $final);
		}
	}
	
	/**
	 * @name 开始备份
	 */
	private function StartBackup($addcheck = true) {
		$this->file_name = $this->getPath() . $this->back_file . date ( 'YmdHis' ) . '.sql';

		$this->fp = fopen($this->file_name, 'w+');

		if ($this->fp == null){
			return false;
		}

		$this->writeLine(self::LINE);

		if ($addcheck) {
			$this->writeLine('SET AUTOCOMMIT=0;');
			$this->writeLine('START TRANSACTION;');
			$this->writeLine('SET SQL_QUOTE_SHOW_CREATE = 1;');
		}

		$this->writeLine('SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;');
		$this->writeLine('SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;');
		$this->writeLine(self::LINE);

		$this->writeComment('START BACKUP');

		return true;
	}

	/**
	 * @name 结束备份
	 */
	private function EndBackup($addcheck = true) {


		$this->writeLine(self::LINE);
		$this->writeLine('SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;');
		$this->writeLine('SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;');
		
		if ($addcheck) {
			$this->writeLine('COMMIT;');
		}
		$this->writeLine(self::LINE);
		$this->writeComment('END BACKUP' );
		fclose($this->fp);
		$this->fp = null;
		if ($this->enableZip) {
			$this->createZipBackup();
		}
	}
	
	
	

	private function execSqlFile($sqlFile) {
		$message = "ok";
		
		if (file_exists($sqlFile)) {
			$content = file_get_contents($sqlFile);
			$sqls = self::parseSql($content);

			if (is_array($sqls)) {
				try {
					foreach ($sqls as $sql) {
						if (trim($sql) == '') {
							continue;
						}
						Yii::$app->db->createCommand($sql)->execute();
					}
				} catch (\Exception $e) {
					$message = $e->getMessage ();
				}
			}
		}

		return $message;
	}
	
	/**
	 * Charge method to backup and create a zip with this
	 */
	private function createZipBackup() {
		$zip = new \ZipArchive ();
		$file_name = $this->file_name . '.zip';
		if ($zip->open ( $file_name, \ZipArchive::CREATE ) === TRUE) {
			$zip->addFile ( $this->file_name, basename ( $this->file_name ) );
			$zip->close ();
			
			@unlink ( $this->file_name );
		}
	}
	
	/**
	 * Method responsible for reading a directory and add them to the zip
	 *
	 * @param ZipArchive $zip        	
	 * @param string $alias        	
	 * @param string $directory        	
	 */
	private function zipDirectory($zip, $alias, $directory) {
		if ($handle = opendir ( $directory )) {
			while ( ($file = readdir ( $handle )) !== false ) {
				if (is_dir ( $directory . $file ) && $file != "." && $file != ".." && ! in_array ( $directory . $file . '/', $this->module->excludeDirectoryBackup ))
					$this->zipDirectory ( $zip, $alias . $file . '/', $directory . $file . '/' );
				
				if (is_file ( $directory . $file ) && ! in_array ( $directory . $file, $this->module->excludeFileBackup ))
					$zip->addFile ( $directory . $file, $alias . $file );
			}
			closedir ( $handle );
		}
	}
	/**
	 * Zip file execution
	 *
	 * @param string $zipFile
	 *        	Name of file zip
	 */
	private function unzip($sqlZipFile) {

		if (!file_exists($sqlZipFile)) {
			Yii::$app->session->setFlash('success', '文件不存在');
			return false;
		}

		$zip = new \ZipArchive ();
		if ($zip->open($sqlZipFile)) {
			$zip->extractTo(dirname($sqlZipFile));
			$zip->close ();
			$sqlZipFile = str_replace(".zip", "", $sqlZipFile);
		}

		return $sqlZipFile;
	}
	protected function updateMenuItems($model = null) {
		// create static model if model is null
		if ($model == null)
			$model = new UploadForm ();
		
		switch ($this->action->id) {
			case 'restore' :
				{
					$this->menu [] = array (
							'label' => Yii::t ( 'app', 'View Site' ),
							'url' => Yii::$app->HomeUrl 
					);
				}
			case 'create' :
				{
					$this->menu [] = array (
							'label' => Yii::t ( 'app', 'List Backup' ),
							'url' => array (
									'index' 
							) 
					);
				}
				break;
			case 'upload' :
				{
					$this->menu [] = array (
							'label' => Yii::t ( 'app', 'Create Backup' ),
							'url' => array (
									'create' 
							) 
					);
				}
				break;
			default :
				{
					$this->menu [] = array (
							'label' => Yii::t ( 'app', 'List Backup' ),
							'url' => array (
									'index' 
							) 
					);
					$this->menu [] = array (
							'label' => Yii::t ( 'app', 'Create Backup' ),
							'url' => array (
									'create' 
							) 
					);
					$this->menu [] = array (
							'label' => Yii::t ( 'app', 'Upload Backup' ),
							'url' => array (
									'upload' 
							) 
					);
					// $this->menu[] = array('label'=>Yii::t('app', 'Restore Backup') , 'url'=>array('restore'));
					$this->menu [] = array (
							'label' => Yii::t ( 'app', 'Clean Database' ),
							'url' => array (
									'clean' 
							) 
					);
					$this->menu [] = array (
							'label' => Yii::t ( 'app', 'View Site' ),
							'url' => Yii::$app->HomeUrl 
					);
				}
				break;
		}
	}

	private function writeComment($string) {
		$this->writeLine(self::LINE);
		$this->writeLine('-- ' . $string);
		$this->writeLine(self::LINE);
	}


	private function writeLine($line)
	{
		fwrite($this->fp, $line . PHP_EOL);
	}

	private function getSize($filename, $format) {  

		$size = filesize($filename);
	    $p = 0;  
	    if ($format == 'kb') {  
	        $p = 1;  
	    } elseif ($format == 'mb') {  
	        $p = 2;  
	    } elseif ($format == 'gb') {  
	        $p = 3;  
	    }  
	    $size /= pow(1024, $p);  

	    return number_format($size, 3);  
	}

	private function getPath()
	{
		$path = Yii::getAlias('@app/web/backup/');

		if (!file_exists($path)) {
			@mkdir($path) or die('创建备份目录失败');
			chmod($path, '755');
		}

		return $path;
	}

	private function getFileList($ext = '*.sql')
	{
		$list_files = glob($this->getPath() . $ext);

		$list = [];
		if ($list_files) {
			$list = array_map('basename', $list_files);
			sort($list);
		}

		return $list;
	}
}
