<?php

namespace app\modules\mess\controllers\admin;

use app\modules\mess\models\Mess;
use app\modules\mess\models\MessDayMenu;
use app\modules\mess\models\MessMenu;
use app\modules\mess\models\MessReception;
use app\modules\mess\models\MessReceptionMenu;
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

        $_menus = MessUserOrderMenu::find()->where($option)
            ->orderBy('is_over asc')
            ->all();


        $menus = [];
        foreach ($_menus as $menu) {
            $menus[$menu->is_over][$menu->user_id][] = $menu;
        }


//        $menus = ArrayHelper::index($_menus, 'id', 'user_id');


        /**
         * 订餐统计
         */
        $_result = MessUserOrderMenu::find()->where($option)
            ->select('menu_id,sum(num) as cnt,sum(is_over*num) as over')
            ->groupBy('menu_id')
            ->indexBy('menu_id')
            ->asArray()
            ->all();
        $_reception_result = MessReceptionMenu::find()->where($option+['status'=>MessReceptionMenu::STATUS_NORMAL])
            ->select('menu_id, sum(num) as cnt,sum(is_over*num) as over')
            ->groupBy('menu_id')
            ->indexBy('menu_id')
            ->asArray()
            ->all();

        $ms = MessMenu::find()->where(['id'=>array_merge(array_keys($_result), array_keys($_reception_result))])
            ->indexBy('id')
            ->asArray()->all();

        $result = [];
        foreach ($ms as $k=>$v) {
            $rcnt = isset($_result[$k]['cnt']) ? $_result[$k]['cnt'] : 0;
            $rover = isset($_result[$k]['over']) ? $_result[$k]['over'] : 0;
            $rrcnt = isset($_reception_result[$k]['cnt']) ? $_reception_result[$k]['cnt'] : 0;
            $rrover = isset($_reception_result[$k]['over']) ? $_reception_result[$k]['over'] : 0;
            $result[$k] = [
                'cnt' => $rcnt + $rrcnt,
                'menu_id' => $k,
                'over'  => $rover + $rrover,
                'menu_name' => $ms[$k]['name']
            ];
        }

        //查找未点餐的人
        $yet = ArrayHelper::getColumn($_menus, 'user_id');

        $not = MessUserPrice::find()
            ->where(['status'=>MessUserPrice::STATUS_NORMAL])
            ->andWhere(['not in', 'user_id', $yet])
            ->all();


        //接待用餐
        $_reception_menus = MessReceptionMenu::find()
            ->where($option+['status'=>MessReceptionMenu::STATUS_NORMAL])
            ->all();
        $_reception_menus_ids = ArrayHelper::getColumn($_reception_menus,'reception_id');
        $receptions = MessReception::find()->where(['id'=>$_reception_menus_ids])->all();

        $reception_menus = ArrayHelper::index($_reception_menus, 'id', 'reception_id');


        return $this->render('index',[
            'date' => $date,
            'types' => $types,
            'mess' => $mess,
            'now_mess' => $now_mess,
            'now_type' => $now_type,
            'menus' => $menus,
            'result' => $result,
            'not' => $not,
            'receptions' => $receptions,
            'reception_menus' => $reception_menus
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
     * @name 领取
     */
    public function actionTakeReception($mess_id, $date, $type, $reception_id)
    {
        if (Yii::$app->request->isPost) {
            $option = [
                'mess_id' => $mess_id,
                'day_time'    => $date,
                'type'    => $type,
                'reception_id' => $reception_id
            ];

            $models = MessReceptionMenu::find()->where($option)->all();

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

        $reception_menus = MessReceptionMenu::find()->where($option)->all();

        return $this->renderAjax('view', [
            'menus' => $menus,
            'reception_menus' => $reception_menus
        ]);
    }

    public function actionOrder($mess_id, $date, $type)
    {

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $user_id = $post['user_id'];
            $menu_ids = $post['menu_id'];
            $num = $post['num'];

            if (!$user_id) {
                Yii::$app->session->setFlash('error', '请选择订餐人');
            }

            $menu_ids = array_filter($menu_ids);
            $data = [
                'user_id' => $user_id,
                'mess_id' => $mess_id,
                'day_time'=> $date,
                'type'    => $type,
                'is_pre'  => 0,
            ];
            foreach ($menu_ids as $k =>$menu) {
                if (!isset($num[$k]) || !$num[$k]) {continue;}
                $mu = MessMenu::findOne($menu);

                $data['menu_id'] = $menu;
                $data['num'] = $num[$k];
                $data['real_price'] = $mu->default_price;

                $model = new MessUserOrderMenu();
                $model->load($data, '');
                $model->save();

            }
            Yii::$app->session->setFlash('success', '订餐完成');

            return $this->redirect('index');

        }

        $types = $this->module->params['menu_types'];
        return $this->renderAjax('order',[
            'types'=> $types,
            'mess_id' => $mess_id,
            'date' => $date,
            'type' => $type
        ]);
    }
}
