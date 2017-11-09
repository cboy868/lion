<?php

namespace app\modules\analysis\controllers\admin;


use app\core\helpers\ArrayHelper;
use app\modules\agency\models\Agency;
use app\modules\analysis\models\SettlementRel;
use app\modules\analysis\models\SettlementTomb;
use app\modules\analysis\models\Settlement;
use app\modules\user\models\User;
use yii;

/**
 * Class GuideController
 * @package app\modules\analysis\controllers\admin
 * @des 本页所有年份应该可选，默认为今年,目前只计墓位销售
 *
 */
class AgencyController extends \app\core\web\BackController
{
    static $cache_term = 3600;

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @name 办事处销售全年占比 饼图
     */
    public function actionYear($year = null)
    {
        $year = $year === null ? date('Y') : $year;


        $cache = Yii::$app->cache;
        $data = $cache->get('agency_year'.$year);

        if ($data === false) {

            $data = Settlement::find()->where(['year'=>$year, 'status'=>1])
                ->select(['agency_id', 'sum(price) as total'])
                ->groupBy('agency_id')
                ->asArray()
                ->all();

            $agency_ids = ArrayHelper::getColumn($data, 'agency_id');
            $agency = Agency::find()->where(['id'=>$agency_ids])->indexBy('id')->all();

            foreach ($data as &$v) {
                $v['guide_name'] = isset($agency[$v['agency_id']]) ? $agency[$v['agency_id']]['title'] : '市场部';
            }unset($v);

            $cache->set('agency_year' . $year, $data, self::$cache_term);
        }


        return $this->json($data, null, 1);
    }


    /**
     * @name 办事处自身纵向对比 办事处可选
     */
    public function actionSelf($agency_id, $year=null)
    {
        $year = $year === null ? date('Y') : $year;

        $cache = Yii::$app->cache;
        $data = $cache->get('agency_self'.$year);

        if ($data === false) {
            $data = Settlement::find()->where(['year'=>$year, 'status'=>1])
                ->andWhere(['agency_id'=>$agency_id])
                ->select(['month', 'sum(price) as total'])
                ->groupBy('month')
                ->asArray()
                ->all();

            $cache->set('agency_self' . $year, $data, self::$cache_term);
        }

        return $this->json($data, null, 1);
    }

    /**
     * @name 办事处各月销售横向对比 月份可选,月份为空，则为全年
     */
    public function actionMonth($year=null, $month=null)
    {
        $month = $month === null ? null : $month;
        $year = $year === null ? date('Y') : $year;


        $cache = Yii::$app->cache;
        $data = $cache->get('agency_month'.$year.$month);

        if ($data === false) {
            $query = Settlement::find()->where(['year'=>$year, 'status'=>1]);

            if ($month) {
                $query->andWhere(['month'=>$month]);
            }
            $data = $query->select(['agency_id', 'sum(price) as total'])
                ->groupBy('agency_id')
                ->asArray()
                ->all();

            $agency_ids = ArrayHelper::getColumn($data, 'agency_id');
            $agency = Agency::find()->where(['id'=>$agency_ids])->indexBy('id')->all();


            foreach ($data as &$v) {
                $v['guide_name'] = isset($agency[$v['agency_id']])?$agency[$v['agency_id']]['title'] : '市场部';
            }unset($v);

            $cache->set('agency_month' . $year . $month, $data, self::$cache_term);

        }

        return $this->json($data, null, 1);
    }




    /**
     * @name 业务员销售全年占比 饼图
     */
    public function actionAgentYear($year = null)
    {
        $year = $year === null ? date('Y') : $year;

        $cache = Yii::$app->cache;
        $data = $cache->get('agent_year'.$year);

        if ($data === false) {
            $data = SettlementRel::find()->where(['year'=>$year, 'status'=>1, 'res_name'=>'tomb'])
                ->select(['agent_id', 'sum(price) as total'])
                ->groupBy('agent_id')
                ->asArray()
                ->all();

            $agent_ids = ArrayHelper::getColumn($data, 'agent_id');
            $agents = User::find()->where(['id'=>$agent_ids])->indexBy('id')->all();

            foreach ($data as &$v) {
                $v['agent_name'] = isset($agents[$v['agent_id']]) ? $agents[$v['agent_id']]['username'] : '业直';
            }unset($v);

            $cache->set('agent_year' . $year, $data, self::$cache_term);
        }

        return $this->json($data, null, 1);
    }

    /**
     * @name 业务员各月墓位销售横向对比 月份可选,月份为空，则为全年
     */
    public function actionAgentMonth($year=null, $month=null)
    {
        $month = $month === null ? null : $month;
        $year = $year === null ? date('Y') : $year;


        $cache = Yii::$app->cache;
        $data = $cache->get('agent_month'.$year.$month);

        if ($data === false) {
            $query = SettlementRel::find()->where(['year'=>$year, 'status'=>1,'res_name'=>'tomb']);

            if ($month) {
                $query->andWhere(['month'=>$month]);
            }
            $data = $query->select(['agent_id', 'sum(price) as total'])
                ->groupBy('agent_id')
                ->asArray()
                ->all();

            $agent_ids = ArrayHelper::getColumn($data, 'agent_id');
            $agents = User::find()->where(['id'=>$agent_ids])->indexBy('id')->all();

            foreach ($data as &$v) {
                $v['agent_name'] = isset($agents[$v['agent_id']])?$agents[$v['agent_id']]['username'] : '业直';
            }unset($v);

            $cache->set('agent_month' . $year.$month, $data, self::$cache_term);
        }

        return $this->json($data, null, 1);
    }
}
