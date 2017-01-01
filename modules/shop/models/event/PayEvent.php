<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\shop\models\event;

/**
 * ModelEvent represents the parameter needed by [[Model]] events.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class PayEvent extends \yii\base\Event
{
    /**
     * @var boolean whether the model is in valid status. Defaults to true.
     * A model is in valid status if it passes validations or certain checks.
     */

    // public $order_id; //订单id

    public $progress; //支付进度    1部分, 2全部

}


