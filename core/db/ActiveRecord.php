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
    const STATUS_DELETE = -1;
	const STATUS_NORMAL = 1;//正常

    const GENDER_NO = 0;
    const GENDER_MALE = 1;
    const GENDER_FMALE = 2;

    const DTNULL = '0000-00-00 00:00:00';
    const DNULL  = '0000-00-00';

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

    public static function gender($gender = null)
    {
        $ar = [
            self::GENDER_NO   => '未知',
            self::GENDER_MALE => '男',
            self::GENDER_FMALE=> '女'
        ];

        if ($gender === null) {
            return $ar;
        }

        return $ar[$gender];
    }

    public function getGenderText()
    {
        return static::gender($this->gender);
    }

    public function getThumbImg($size, $default="/static/images/up.png")
    {

        if (isset($this->thumb) && !empty($this->thumb)) {
            return \app\core\models\Attachment::getById($this->thumb, $size, $default);
        }

        return '';
    }

}
