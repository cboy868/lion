<?php
/**
 * @name 角色
 * 继承自框架
 */
namespace app\modules\sys\rbac;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Role extends Item
{
	public $type = self::TYPE_ROLE;

	public $level = 8;//8表示是角色
}
