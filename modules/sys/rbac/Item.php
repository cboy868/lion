<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\sys\rbac;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Item extends \yii\rbac\Item
{
    const TYPE_ROLE = 1;
    const TYPE_PERMISSION = 2;

    public $real_title;
}
