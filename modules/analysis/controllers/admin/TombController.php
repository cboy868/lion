<?php

namespace app\modules\analysis\controllers\admin;


use app\modules\analysis\models\SettlementTomb;
use app\modules\grave\models\Grave;
use app\modules\grave\models\Tomb;

class TombController extends \app\core\web\BackController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @name 销售数量统计
     */
    public function actionSaleNum()
    {
        $data = SettlementTomb::data(4);
        $result = [];

        foreach ($data as $k => $v) {
//            foreach ($v as $val) {
                for ($i=1; $i <= 12; $i++) {
                    $index = str_pad($i, 2, '0', STR_PAD_LEFT);
                    $result['num'][$k][$i] = $v[$k . $index]['num'];
                }
//            }
            $result['num'][$k] = array_values($result['num'][$k]);
            $result['numcate'][$k] = "$k(".$data[$k][$k]['num']."个)";
        }

        ksort($result['numcate']);

        return $this->json($result, null, 1);
    }


    /**
     * @name 销售金额统计
     */
    public function actionSaleAmount()
    {
        $data = SettlementTomb::data(4);
        $result = [];

        foreach ($data as $k => $v) {
//            foreach ($v as $val) {
                for ($i=1; $i <= 12; $i++) {
                    $index = str_pad($i, 2, '0', STR_PAD_LEFT);
                    $result['amount'][$k][$i] = $v[$k . $index]['amount']/10000;
                }
//            }
            $result['amount'][$k] = array_values($result['amount'][$k]);

            $yearAmount = number_format(sprintf("%.2f",$data[$k][$k]['amount']/10000),2);
            $result['amountcate'][$k] = "$k(".$yearAmount."万)";
        }

        ksort($result['amountcate']);

        return $this->json($result, null, 1);
    }

    /**
     * @return array
     * @name 销售数量与金额在一起, actionSaleAmount 与actionSaleNum的组合，调取数据更方便
     */
    public function actionSale()
    {
        $data = SettlementTomb::data(4);
        $result = [];

        foreach ($data as $k => $v) {
//            foreach ($v as $val) {
                for ($i=1; $i <= 12; $i++) {
                    $index = str_pad($i, 2, '0', STR_PAD_LEFT);
                    $result['amount'][$k][$i] = $v[$k . $index]['amount']/10000;
                    $result['num'][$k][$i] = $v[$k . $index]['num'];
                }
//            }
            $result['amount'][$k] = array_values($result['amount'][$k]);
            $result['num'][$k] = array_values($result['num'][$k]);

            $yearAmount = number_format(sprintf("%.2f",$data[$k][$k]['amount']/10000),2);
            $result['amountcate'][$k] = "$k(".$yearAmount."万)";
            $result['numcate'][$k] = "$k(".$data[$k][$k]['num']."个)";
        }

        ksort($result['amountcate']);
        ksort($result['numcate']);

        return $this->json($result, null, 1);
    }

    public function actionGraveStatus($grave_id=null)
    {
        $data = Grave::statusAnalysis($grave_id);
        $statusLabel = Tomb::getSta();

        $result = [];
        foreach ($data as $k=>$v) {
            if (!isset($statusLabel[$k])) continue;
            $result[] = [
                'name' => $statusLabel[$k],
                'value' => $v
            ];
        }
//


        return $this->json($result, null, 1);
    }

    /**
     * @name 导购员销售金额统计
     */



	/**
	 * @name 墓位销售量统计,金额统计
	 */
//    public function actionIndex()
//    {
//
//    	$rels = $this->yearData();
//
//
//
//		p($rels);die;
//
//        return $this->render('index');
//    }


//    private function yearData($year=null)
//    {
//    	if ($year === null) {
//    		$year = date('Y-01-01');
//    	} else {
//    		$year = $year .'-01-01';
//    	}
//
//    	$start = strtotime($year);
//    	$end = strtotime($year . '+1 year');
//
//    	$rels = (new \yii\db\Query())
//			    ->from('{{%order_rel}} as or')
//			    ->where(['or.type' => 9])
//			    ->join('LEFT JOIN', '{{%order}} as o', 'or.order_id = o.id')
//			    ->andWhere(['>=','o.progress', 1])
//			    ->andWhere(['<', 'or.created_at', $end])
//			    ->andWhere(['>=', 'or.created_at', $start])
//			    ->select(['COUNT(*) as cnt', 'SUM(or.price) as total'])
//			    ->groupBy(date('m', 'created_at'))
//			    ->all();
//
//
//		$connection  = Yii::$app->db;
//		$sql = <<<SQL
//SELECT * FROM `order` o
//LEFT JOIN order_rel r ON o.id=r.order_id
//SQL;
//
//
//
//		$command = $connection->createCommand($sql);
//		$res     = $command->queryAll($sql);
//
//
//		return $rels;
//
//
//    }
}
