<?php
namespace app\commands;

use yii;
use yii\console\Controller;
use app\modules\mess\models\MessUserOrderMenu;
use app\modules\mess\models\MessUserPrice;
use app\modules\mess\models\MessStorage;
use app\modules\mess\models\MessMenuFood;
use yii\helpers\ArrayHelper;
/**
 *
 * @author wansq
 * @since 2.0
 * @name 食堂的一些东西 
 */
class CanteenController extends Controller
{
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";
    }

    /**
     * @name 扣费
     * @return [type] [description]
     */
    public function actionAccount()
    {
        $day = date('Y-m-d');
        $prices = MessUserOrderMenu::find()->where(['day_time'=>$day,'status'=>MessUserOrderMenu::STATUS_NORMAL,'is_over'=>0])
                                            ->select('user_id, sum(real_price*num) as total')
                                            ->groupBy('user_id')
                                            ->asArray()
                                            ->all();
        foreach ($prices as $k => $price) {
            $u = MessUserPrice::find()->where(['user_id'=>$price['user_id']])->one();
            if (!$u) {
                continue;
            }
            $u->price = $u->price - $price['total'];
            $u->save();
        }

        if (count($prices)>0) {
            $connection = Yii::$app->db;

            $connection->createCommand()
                        ->update(
                            MessUserOrderMenu::tableName(),
                            ['is_over'=>1],
                            ['day_time'=>$day,'status'=>MessUserOrderMenu::STATUS_NORMAL]
                        )->execute();
        }

        return true;
    }


    /**
     * @name 出库
     * @return [type] [description]
     */
    public function actionOut()
    {

        $day = date('Y-m-d');
        $day = '2017-11-23';
        //SELECT mess_id,menu_id,sum(num) FROM `mess_user_order_menu` where id>1 GROUP BY mess_id,menu_id
        $menus = MessUserOrderMenu::find()->where(['day_time'=>$day,'status'=>MessUserOrderMenu::STATUS_NORMAL])
                                            ->select('mess_id, menu_id, sum(num) as num')
                                            ->groupBy('mess_id, menu_id')
                                            ->asArray()
                                            ->all();

        //计算每个食堂的食材消耗
        $mess = [];
        foreach ($menus as $k => $menu) {
            $mess[$menu['mess_id']][] = $menu;
        }

        foreach ($mess as $k => $v) {
            $menu_ids = ArrayHelper::getColumn($v, 'menu_id');
            $foods = MessMenuFood::find()->where(['menu_id'=>$menu_ids])
                                    ->select('food_id, sum(num) as num')
                                    ->groupBy('food_id')
                                    ->all();


            foreach ($foods as $key => $food) {
                $fm = MessStorage::find()->where(['mess_id'=>$k,'food_id'=>$food->food_id])->one();
                if (!$fm) {
                    continue;
                }

                $fm->num = $fm->num - $food->num;
                $fm->save();
            }
        }
    }
}
