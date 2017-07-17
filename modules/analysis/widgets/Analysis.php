<?php
/**
 * Created by PhpStorm.
 * User: wansq
 * Date: 2017/5/15
 * Time: 14:40
 */

namespace app\modules\analysis\widgets;

use yii;
use app\core\helpers\ArrayHelper;
use app\modules\task\models\Task;
use app\modules\mod\models\Code;
use app\core\db\ActiveRecord;
use app\modules\client\models\Client;

/**
 * The ZActiveForm widget extend ActiveForm.
 *
 * @author wsq <cboy868@163.com>
 */
class Analysis extends \yii\base\Widget
{

    public $name;

    public $uid;

    /**
     * Renders the widget.
     */
    public function run() {
        $method = $this->name;
        $this->uid = Yii::$app->user->id;
        return $this->$method();
    }


    /**
     * @return string
     * @name 总销量及金额
     */
    private function tombNum()
    {
        return $this->render('tomb/num');
    }

    private function tombAmount()
    {
        return $this->render('tomb/amount');
    }


}