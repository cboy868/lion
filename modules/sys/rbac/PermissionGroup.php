<?php
/**
 * @name 权限组
 * 
 * 一组权限，其实属于角色，这样设计，为使之后的用户操作更加方便
 */
namespace app\modules\sys\rbac;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class PermissionGroup extends Item
{
	public $type = self::TYPE_ROLE;
	
	public $level = 7;
}
