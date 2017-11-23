<?php

namespace app\modules\mess\controllers\admin;

use app\modules\mess\models\Mess;
use app\modules\mess\models\MessDayMenu;
use app\modules\mess\models\MessMenu;
use app\modules\mess\models\MessUserPrice;
use Yii;
use app\modules\mess\models\MessUserOrderMenu;
use app\modules\mess\models\SearchMessUserOrderMenu;
use app\core\web\BackController;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * 厨师操作面板
 */
class PanelController extends BackController
{

    /**
     * @param null $date
     * @param null $mess_id
     * @param null $type_id
     * @return string
     * @name 厨师工作台
     */
    public function actionIndex($date=null, $mess_id=null, $type=null)
    {
        $types = $this->module->params['menu_types'];
        $mess = Mess::sel();
        $date = $date ? $date : date('Y-m-d');
        $now_mess = $mess_id && isset($mess[$mess_id]) ? $mess_id : key($mess);
        $now_type = $type && isset($types[$type]) ? $type : key($types);


        $option = [
            'day_time'=>$date,
            'type' => $now_type,
            'mess_id' => $now_mess,
        ];

        $_menus = MessUserOrderMenu::find()->where($option)->orderBy('is_over asc')->all();

        $menus = ArrayHelper::index($_menus, 'id', 'user_id');


        $result = MessUserOrderMenu::find()->where($option)
            ->select('menu_id,count(*) as cnt,sum(is_over) as over')
            ->groupBy('menu_id')
            ->indexBy('menu_id')
            ->asArray()
            ->all();
        $ms = MessMenu::find()->where(['id'=>array_keys($result)])->indexBy('id')
            ->asArray()->all();

        foreach ($result as $k =>&$v){
            $v['menu_name'] = $ms[$k]['name'];
        }unset($v);


        //查找未点餐的人
        $yet = ArrayHelper::getColumn($_menus, 'user_id');

        $not = MessUserPrice::find()
            ->where(['status'=>MessUserPrice::STATUS_NORMAL])
            ->andWhere(['not in', 'user_id', $yet])
            ->all();

        return $this->render('index',[
            'date' => $date,
            'types' => $types,
            'mess' => $mess,
            'now_mess' => $now_mess,
            'now_type' => $now_type,
            'menus' => $menus,
            'result' => $result,
            'not' => $not
        ]);
    }

    /**
     * @name 领取
     */
    public function actionTake($mess_id, $date, $type, $user_id)
    {
        if (Yii::$app->request->isPost) {
            $option = [
                'mess_id' => $mess_id,
                'day_time'    => $date,
                'type'    => $type,
                'user_id' => $user_id
            ];

            $models = MessUserOrderMenu::find()->where($option)->all();

            foreach ($models as $model) {
                $model->is_over = 1;
                $model->save();
            }

            return $this->json();
        }

        return $this->json(null, '您无此权限', 0);
    }

    /**
     * @name 删除
     */
    public function actionDrop($id)
    {
        if (Yii::$app->request->isPost) {
            $model = MessUserOrderMenu::findOne($id);
            if ($model->delete()) {
                return $this->json();
            } else {
                return $this->json(null, '删除失败', 0);
            }
        }

        return $this->json(null, '您无此权限', 0);
    }

    /**
     * @param $menu_id
     * @name 菜单详情
     */
    public function actionView($mess_id, $type, $menu_id, $date)
    {
        $option = [
            'mess_id' => $mess_id,
            'type'    => $type,
            'menu_id' => $menu_id,
            'day_time'=> $date
        ];
        $menus = MessUserOrderMenu::find()->where($option)->all();

        return $this->renderAjax('view', [
            'menus' => $menus
        ]);
    }
}
