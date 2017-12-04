<?php
/**
 * 有时控制器不起作用，改个名字有可能就好了，名字有一部分与系统中的控制器重复也会失败
 */

namespace app\commands;

use yii;
use yii\console\Controller;
use app\modules\sys\models\Msg;
/**
 *
 * @author wansq
 * @since 2.0
 */
class MsgController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";
    }


    public function actionSend()
    {
        Msg::batch();
    }

}
