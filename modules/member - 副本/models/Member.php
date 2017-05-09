<?php 

namespace app\modules\member\models;

use Yii;
use app\core\models\Attachment;


/**
* 公共函数
*/
class Member
{
	
	/**
	 * @name 取头像
	 */
	public static function getAvatar($size=null)
	{
		$avatar = Yii::$app->user->identity->avatar;

		return Attachment::getById($avatar, $size);
	}
}
?>