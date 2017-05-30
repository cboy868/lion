<?php
namespace app\modules\analysis\controllers\admin;

// use app\modules\grave\models\Tomb;
use app\modules\analysis\models\SettlementTomb;

class DefaultController extends \app\core\web\BackController
{
    /**
     * @return string
     * @name 数据统计首页
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


//    public function actionTestJson()
//    {
//    	$data['cate'] = ["衬衫","羊毛衫","雪纺衫","裤子","高跟鞋","袜子"];
//    	$data['data'] = [5, 20, 36, 10, 10, 20];
//
//    	return $this->json($data);
//    }

    /**
     * @name 墓位统计
     */
    public function actionTomb()
    {
        return $this->render('tomb');
    }

    /**
     * @name 销量统计
     */
    public function actionTombSale()
    {
        $data = SettlementTomb::data(4);
        $result = [];

        foreach ($data as $k => $v) {
            foreach ($v as $val) {
                for ($i=1; $i <= 12; $i++) { 
                    $index = str_pad($i, 2, '0', STR_PAD_LEFT);
                    $result['amount'][$k][$i] = $v[$k . $index]['amount']/10000;
                    $result['num'][$k][$i] = $v[$k . $index]['num'];
                }
            }
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

}
