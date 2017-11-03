<?php

namespace app\modules\analysis\controllers\home;


use app\core\helpers\ArrayHelper;
use app\modules\analysis\models\SettlementTomb;
use app\modules\analysis\models\Settlement;
use app\modules\user\models\User;

/**
 * Class GuideController
 * @package app\modules\analysis\controllers\admin
 * @des 本页所有年份应该可选，默认为今年,目前只计墓位销售
 *
 */
class GuideController extends \app\core\web\HomeController
{
    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * @name 全年占比 饼图
     */
    public function actionYear($year = null)
    {
        //SELECT guide_id,SUM(price) FROM `settlement` WHERE year='2017' GROUP BY guide_id
        $year = $year === null ? date('Y') : $year;
        $data = Settlement::find()->where(['year'=>$year, 'status'=>1])
            ->andWhere(['<>', 'guide_id', 0])
            ->select(['guide_id', 'sum(price) as total'])
            ->groupBy('guide_id')
            ->asArray()
            ->all();

        $guide_ids = ArrayHelper::getColumn($data, 'guide_id');
        $guides = User::find()->where(['id'=>$guide_ids])->indexBy('id')->all();

        foreach ($data as &$v) {
            $v['guide_name'] = $guides[$v['guide_id']]['username'];
        }unset($v);


        return $this->json($data, null, 1);
    }


    /**
     * @name 导购员自身纵向对比 人员可选
     */
    public function actionSelfMonth($guide_id, $year=null)
    {
        $year = $year === null ? date('Y') : $year;

        $data = Settlement::find()->where(['year'=>$year, 'status'=>1])
            ->andWhere(['guide_id'=>$guide_id])
            ->select(['month', 'sum(price) as total'])
            ->groupBy('month')
            ->asArray()
            ->all();
        return $this->json($data, null, 1);
    }

    /**
     * @name 导购员各月销售横向对比 月份可选
     */
    public function actionMonth($year=null, $month=null)
    {
        $month = $month === null ? date('m') : $month;
        $year = $year === null ? date('Y') : $year;

        $data = Settlement::find()->where(['year'=>$year, 'status'=>1, 'month'=>$month])
            ->andWhere(['<>', 'guide_id', 0])
            ->select(['guide_id', 'sum(price) as total'])
            ->groupBy('guide_id')
            ->asArray()
            ->all();

        $guide_ids = ArrayHelper::getColumn($data, 'guide_id');
        $guides = User::find()->where(['id'=>$guide_ids])->indexBy('id')->all();

        foreach ($data as &$v) {
            $v['guide_name'] = $guides[$v['guide_id']]['username'];
        }unset($v);


        return $this->json($data, null, 1);
    }

    /**
     * @name 导购员各月销售占比
     */
    public function actionMonthPercent()
    {

    }
}
