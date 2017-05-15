<?php
/**
 * Created by PhpStorm.
 * User: wansq
 * Date: 2017/5/15
 * Time: 14:40
 */

namespace app\modules\grave\widgets;

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

    public $limit = 20;
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
    private function tomb()
    {
        return $this->render('analysis/tomb');
    }

    /**
     * @name 销售统计
     */
//    private function sale()
//    {
//        return $this->render('analysis/sale');
//    }




}