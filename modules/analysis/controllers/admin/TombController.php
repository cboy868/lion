<?php

namespace app\modules\analysis\controllers\admin;

class TombController extends \app\core\web\BackController
{


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
