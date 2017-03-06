<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\core\db;

use Yii;

class ActiveRecord extends \yii\db\ActiveRecord
{

	const STATUS_DEL = -1;
	const STATUS_NORMAL = 1;//正常

    public function del()
    {
    	$this->status = self::STATUS_DEL;
    	return $this->save();
    }


    public function getStatusText()
    {
    	return static::status($this->status);
    }


    public static function status($status = null)
    {
    	$s = [
    		self::STATUS_DEL => '删除',
    		self::STATUS_NORMAL => '正常'
    	];

    	if ($status === null) {
    		return $s;
    	}

    	return $s[$status];
    }

}
