<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\core\helpers;

/**
 * File system helper
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @author Alex Makarov <sam@rmcreative.ru>
 * @since 2.0
 */
class FileHelper extends \yii\helpers\BaseFileHelper
{

	public static function findFiles($dir, $is_dir = true) {
		$list = [];
		$handle = @opendir($dir);
		if ($handle === false) {
			throw new InvalidParamException("目录不存在: $dir");
		}
		while (($file = readdir($handle)) !== false) {
			if ($file === '.' || $file === '..') {
				continue;
			}
			$path = $dir . DIRECTORY_SEPARATOR . $file;
			if (is_dir($path) == $is_dir) {
				$list[] = $file;
			}
		}
		closedir($handle);

		return $list;
	}
	/**
	 * 取得目录下所有主题
	 */
	public static function getThemes($dir, $url) {
		$themes = self::findFiles($dir);


		$result = [];
		foreach ($themes as $k => $v) {

			if (strpos($v, '.bak')) {
				continue ;
			}
			$screenshot = $dir . DIRECTORY_SEPARATOR . $v . DIRECTORY_SEPARATOR . 'screenshot.png';


			$web_url = $url . DIRECTORY_SEPARATOR . $v . DIRECTORY_SEPARATOR . 'screenshot.png';

			$result[$v]['screenshot'] = is_file($screenshot) ? $web_url : '';
		}

		return $result;
	}
}
