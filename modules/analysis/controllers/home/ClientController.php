<?php

namespace app\modules\analysis\controllers\home;


use app\modules\client\models\Client;
use app\modules\client\models\Reception;
use app\core\helpers\ArrayHelper;
use app\modules\user\models\User;

class ClientController extends \app\core\web\HomeController
{
    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * @name 总接待数量统计
     */
    public function actionYear($year = null)
    {
        $year = $year === null ? date('Y') : $year;

        $start = strtotime($year .'-01-01 00:00:00');
        $end = strtotime($year. '-12-31 24:59:59');

        //人数
        $data = Client::find()->where(['status'=>1])
            ->andFilterWhere(['between','created_at', $start, $end])
            ->andFilterWhere(['<>', 'guide_id', 0])
            ->select(['guide_id', 'count(id) as total'])
            ->groupBy('guide_id')
            ->indexBy('guide_id')
            ->asArray()
            ->all();

        $guide_ids = ArrayHelper::getColumn($data, 'guide_id');



        //接待次数

        $rec_data = Reception::find()->where(['status'=>1])
            ->andFilterWhere(['between','created_at', $start, $end])
            ->andFilterWhere(['<>', 'guide_id', 0])
            ->select(['guide_id', 'count(id) as total'])
            ->groupBy('guide_id')
            ->indexBy('guide_id')
            ->asArray()
            ->all();
        $rec_guide_ids = ArrayHelper::getColumn($rec_data, 'guide_id');
        $guide_ids = array_merge($guide_ids, $rec_guide_ids);
        $guides = User::find()->where(['id'=>$guide_ids])->indexBy('id')->asArray()->all();

        $result = [];
        foreach ($guides as $v) {
            $result[] = [
                'guide_name' => $v['username'],
                'person_total' => isset($data[$v['id']]['total']) ? $data[$v['id']]['total'] : 0,
                'recept_total' => isset($rec_data[$v['id']]['total']) ? $rec_data[$v['id']]['total'] :0
            ];
        }
        return $this->json($result, null, 1);
    }

    /**
     * @name 导购员接待量统计
     */
    public function actionGuide()
    {

    }

}
