<?php

namespace app\modules\mess\controllers\admin;

use app\modules\mess\models\Mess;
use app\modules\mess\models\MessUserOrderMenu;
use Yii;
use app\modules\mess\models\MessDayMenu;
use app\modules\mess\models\SearchMessDayMenu;
use app\core\web\BackController;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use app\modules\mess\models\SearchMessUserRecharge;
use app\modules\mess\models\SearchMessUserOrderMenu;
/**
 * DayController implements the CRUD actions for MessDayMenu model.
 */
class ProfileController extends BackController
{

    /**
     * Lists all MessDayMenu models.
     * @return mixed
     */
    public function actionIndex($date=null)
    {
        $date = $date ? $date : date('Y-m-d');

        $_menus = MessDayMenu::find()->where(['day_time'=>$date,'status'=>MessDayMenu::STATUS_NORMAL])
            ->all();
        $menus = [];
        foreach ($_menus as $menu) {
            $menus[$menu->mess_id][$menu->type][] = $menu;
        }


        $_self_menus = MessUserOrderMenu::find()->where(['user_id'=>Yii::$app->user->id])
            ->andWhere(['day_time'=>$date])
            ->orderBy('mess_id asc,type asc')
            ->all();

        $self_menus = [];
        foreach ($_self_menus as $menu) {
            $self_menus[$menu->mess_id][$menu->type][$menu->day_menu_id] = $menu;
        }

        $types = $this->module->params['menu_types'];

        return $this->render('index',[
            'mess' => Mess::sel(),
            'types'=> $types,
            'menus' => $menus,
            'self' => $self_menus,
            'self_menus' => $_self_menus,
            'date' => $date
        ]);
    }

    public function actionList($date=null)
    {
        $date = $date ? $date : date('Y-m-d');
        $self_menus = MessUserOrderMenu::find()->where(['user_id'=>Yii::$app->user->id])
            ->andWhere(['day_time'=>$date])
            ->orderBy('mess_id asc,type asc')
            ->all();

        $types = $this->module->params['menu_types'];

        return $this->renderAjax('list',[
            'self_menus' => $self_menus,
            'types'=> $types,
            'date' => $date
        ]);
    }

    public function actionCreate()
    {
        $post = Yii::$app->request->post();

        $menu = MessDayMenu::findOne($post['id']);
        if (!$menu) {
            return $this->json(null, '此菜单不存在', 0);
        }

        $options = [
            'day_time' => $menu->day_time,
            'mess_id'  => $menu->mess_id,
            'type'     => $menu->type,
            'day_menu_id' => $menu->id,
            'user_id'  => Yii::$app->user->id,
            'menu_id'  => $menu->menu_id
        ];

        $model = MessUserOrderMenu::find()->where($options)->one();

        if ($post['num'] <=0) {
            if ($model) {
                if ($model->delete()) {
                    return $this->json($model, '取消成功', 1);
                }
                return $this->json(null, '取消失败', 0);
            } else {
                return $this->json(null, '订餐不存在', 0);
            }

        }

        if (!$model){//如果不存在，则创建一个
            $model = new MessUserOrderMenu();
            $model->load($options, '');
        }

        $model->real_price = $menu->real_price;
        $model->num = $post['num'];
        $model->is_pre = 1;


        if ($model->save()) {
            return $this->json($model, '订餐成功', 1);
        } else {
            return $this->json(null, '数据验证失败', 0);
        }
    }

    /**
     * @name 充值记录
     */
    public function actionRecharge()
    {
        $params = Yii::$app->request->queryParams;
        $params['SearchMessUserRecharge']['user_id'] = Yii::$app->user->id;
        $searchModel = new SearchMessUserRecharge();
        $dataProvider = $searchModel->search($params);

        return $this->render('recharge', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @name 消费记录
     */
    public function actionConsume()
    {
        $params = Yii::$app->request->queryParams;
        $params['SearchMessUserOrderMenu']['user_id'] = Yii::$app->user->id;
        $searchModel = new SearchMessUserOrderMenu();

        $dataProvider = $searchModel->search($params);

        $types = $this->module->params['menu_types'];

        return $this->render('consume', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'types'=> $types,
        ]);
    }

    /**
     * Finds the MessDayMenu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MessDayMenu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MessDayMenu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
