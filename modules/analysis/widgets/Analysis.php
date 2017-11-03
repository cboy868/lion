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

    public $options;

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
     * @desc 暂时有问题，应该只能列出一年的，目的 是想把销售量和金额放在一起展示 再说
     */
    private function tombSales()
    {
        return $this->render('tomb/sales');
    }

    private function tombNum()
    {
        return $this->render('tomb/num');
    }

    private function tombAmount()
    {
        return $this->render('tomb/amount');
    }

    private function guideYearPercent()
    {
        return $this->render('guide/year-percent');
    }

    private function guideYearCompare()
    {
        return $this->render('guide/year-compare');
    }

    private function guideSelfMonth()
    {
        return $this->render('guide/self-month');
    }

    private function guideMonthCompare()
    {
        return $this->render('guide/month-compare');
    }

    private function guideMonthPercent()
    {
        return $this->render('guide/month-percent');
    }

    private function graveStatus()
    {
        $data['grave_id'] = isset($this->options['grave_id']) ? $this->options['grave_id'] : null;

        return $this->render('tomb/grave', $data);
    }

    private function clientYearCompare()
    {
        return $this->render('client/year-compare');
    }

    private function clientYearPercent()
    {
        return $this->render('client/year-percent');
    }


}